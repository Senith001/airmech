<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'RTMEGA_NOTICE_SOURCE_URL' ) ) {
    define( 'RTMEGA_NOTICE_SOURCE_URL', 'https://reactheme.com/products/license/' );
}

class RTMEGA_NoticeDashboard {

    /**
     * Slug this plugin identifies itself as when calling the notice API.
     * Each consuming plugin MUST set its own slug here — using a global
     * constant breaks when multiple notice-consuming plugins are activated
     * (the first one to load wins, and others request notices for the
     * wrong slug).
     */
    const PLUGIN_SLUG = 'rt-mega-menu';

    /**
     * Display names for known plugin slugs. Used as a fallback when the
     * API response doesn't include a sub_title — we derive the name from
     * whichever plugin is currently consuming this NoticeDashboard.
     */
    private static $plugin_slug_titles = array(
        'boldpost'                  => 'boldpost',
        'easy-bookmark'             => 'Easy bookmark',
        'easy-currency'             => 'Easy Currency',
        'easy-elements'             => 'Easy Elements',
        'easy-hotel'                => 'easy hotel',
        'easy-menu-icons'           => 'easy menu icons',
        'easy-wishlist'             => 'easy wishlist',
        'themewant-product-gallery' => 'Easy Product Gallery',
        'rt-mega-menu'              => 'RT Mega Menu',
    );

    private static $instance = null;

    /**
     * Notice IDs this instance has claimed for its dashboard widget. Set at
     * wp_dashboard_setup time; consumed by the widget callback so we only
     * render notices that another consuming plugin hasn't already taken.
     */
    private $my_widget_notice_ids = array();

    /**
     * Cached widget-screen API response so we don't hit the API twice (once
     * to decide whether to register the widget, once to render it).
     */
    private $cached_widget_notices = null;

    public static function get_instance() {
        if ( self::$instance === null ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct() {
        add_action( 'admin_notices', array( $this, 'RTMEGA_notice_add_to_notice_bar' ) );
        add_action( 'wp_dashboard_setup', array( $this, 'RTMEGA_notice_add_to_dashboard_widget' ), 9999 );
        add_action( 'wp_ajax_RTMEGA_notice_ignore_plugin_notice', array( $this, 'RTMEGA_notice_ignore_plugin_notice' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'RTMEGA_notice_enqueue_widget_assets' ) );
    }

    /**
     * Load CSS on every admin page so notice-bar (which can render
     * anywhere) is styled correctly. Dashboard widget styles are also
     * included in the same file — harmless on non-dashboard pages.
     */
    public function RTMEGA_notice_enqueue_widget_assets( $hook ) {
        wp_register_style(
            'rtmega-notice-admin-style',
            RTMEGA_MENU_DIR_URL . 'admin/includes/NoticeDashboard/notice.css',
            array( 'dashicons' ),
            RTMEGA_MENU_VERSION
        );
        wp_enqueue_style( 'rtmega-notice-admin-style' );

        wp_register_script(
            'rtmega-notice-admin-script',
            RTMEGA_MENU_DIR_URL . 'admin/includes/NoticeDashboard/notice.js',
            array( 'jquery' ),
            RTMEGA_MENU_VERSION,
            true
        );
        wp_localize_script( 'rtmega-notice-admin-script', 'RTMEGANoticeData', array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'RTMEGA_notice_nonce' ),
        ) );
        wp_enqueue_script( 'rtmega-notice-admin-script' );
    }

    public function RTMEGA_notice_ignore_plugin_notice() {

        $user_id = get_current_user_id();

        check_ajax_referer( 'RTMEGA_notice_nonce', 'nonce' );

        if ( ! current_user_can( 'read' ) ) {
            wp_send_json_error( array( 'message' => esc_html__( 'You do not have permission to perform this action.', 'rt-mega-menu' ) ) );
        }

        if ( isset( $_POST['notice_id'] ) && ! empty( $_POST['notice_id'] ) ) {

            $notice_id = sanitize_text_field( wp_unslash( $_POST['notice_id'] ) );

            if ( $user_id && ! get_user_meta( $user_id, 'thewtmc_notice_ignore_' . $notice_id, true ) ) {
                add_user_meta( $user_id, 'thewtmc_notice_ignore_' . $notice_id, 'true', true );
            } else {
                update_user_meta( $user_id, 'thewtmc_notice_ignore_' . $notice_id, 'true' );
            }

            wp_send_json_success();
        }

        wp_die();
    }

    public function get_notice_status( $notice_id ) {
        $user_id = get_current_user_id();
        return get_user_meta( $user_id, 'thewtmc_notice_ignore_' . $notice_id, true );
    }

    /**
     * Return the display name for the currently consuming plugin (based on
     * PLUGIN_SLUG). Empty string if the slug isn't in the known list.
     */
    public function get_active_plugin_display_name() {
        if ( isset( self::$plugin_slug_titles[ self::PLUGIN_SLUG ] ) ) {
            return self::$plugin_slug_titles[ self::PLUGIN_SLUG ];
        }
        return '';
    }

    /**
     * Fetch notices from the central source. Always tags requests with this
     * plugin's own slug so the API returns global + plugin-targeted notices.
     */
    public function RTMEGA_notice_get_notices( $args = array() ) {

        if ( empty( $args['plugin'] ) ) {
            $args['plugin'] = self::PLUGIN_SLUG;
        }

        $notice_source_url = trailingslashit( RTMEGA_NOTICE_SOURCE_URL ) . 'wp-json/reacthemes/v1/get_thewtmc';

        $cache_key = 'rtmega_dash_notice_' . md5( wp_json_encode( $args ) );
        $cached    = get_transient( $cache_key );
        if ( false !== $cached ) {
            return $cached;
        }

        $response = wp_remote_post(
            $notice_source_url,
            array(
                'headers'     => array( 'Content-Type' => 'application/json' ),
                'timeout'     => 10,
                'redirection' => 5,
                'blocking'    => true,
                'sslverify'   => true,
                'data_format' => 'body',
                'body'        => wp_json_encode( $args ),
            )
        );

        if ( is_wp_error( $response ) ) {
            set_transient( $cache_key, '', 10 * MINUTE_IN_SECONDS );
            return '';
        }

        $notice_body = wp_remote_retrieve_body( $response );
        set_transient( $cache_key, $notice_body, 12 * HOUR_IN_SECONDS );

        return $notice_body;
    }

    /**
     * Per-request dedup: when more than one ThemeWant plugin ships this
     * NoticeDashboard, each makes its own API call and gets back the same
     * global/multi-targeted notices. We claim each notice_id once across
     * plugins so it's only rendered by whichever instance reaches it first.
     *
     * Two separate pools because notice-bar and widget use different screen
     * contexts on the API and never share IDs.
     */
    private function claim_noticebar_id( $notice_id ) {
        if ( empty( $notice_id ) ) {
            return false;
        }
        if ( ! isset( $GLOBALS['thewtmc_noticebar_claims'] ) ) {
            $GLOBALS['thewtmc_noticebar_claims'] = array(); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- Intentionally shared cross-plugin claim pool; must use the same name across ThemeWant plugins.
        }
        if ( isset( $GLOBALS['thewtmc_noticebar_claims'][ $notice_id ] ) ) {
            return false;
        }
        $GLOBALS['thewtmc_noticebar_claims'][ $notice_id ] = true; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- Intentionally shared cross-plugin claim pool; must use the same name across ThemeWant plugins.
        return true;
    }

    /**
     * Fetch widget-screen notices once per request and cache. Called from
     * both the wp_dashboard_setup phase (to decide whether to register the
     * widget at all) and from the widget callback (to render).
     */
    private function fetch_widget_notices_once() {
        if ( $this->cached_widget_notices !== null ) {
            return $this->cached_widget_notices;
        }
        $body = $this->RTMEGA_notice_get_notices( array( 'screen' => 'in-widget' ) );
        if ( empty( $body ) ) {
            $this->cached_widget_notices = array();
            return $this->cached_widget_notices;
        }
        $decoded = json_decode( $body, true );
        $this->cached_widget_notices = is_array( $decoded ) ? $decoded : array();
        return $this->cached_widget_notices;
    }

    public function expire_notice_by_date( $notice_id, $expire_timestamp ) {

        $today_date      = gmdate( 'Y-m-d' );
        $today_timestamp = strtotime( $today_date );

        if ( $today_timestamp >= $expire_timestamp ) {
            $user_id = get_current_user_id();
            delete_user_meta( $user_id, 'thewtmc_notice_ignore_' . $notice_id );
        }
    }

    public function RTMEGA_notice_add_to_notice_bar() {

        $args = array( 'screen' => 'notice-bar' );

        $all_notice = $this->RTMEGA_notice_get_notices( $args );

        if ( empty( $all_notice ) ) {
            return;
        }

        $today_date      = gmdate( 'Y-m-d' );
        $today_timestamp = strtotime( $today_date );
        $all_notice      = json_decode( $all_notice, true );

        if ( ! is_array( $all_notice ) ) {
            return;
        }

        foreach ( $all_notice as $notice ) {

            $notice_id        = isset( $notice['notice_id'] ) ? $notice['notice_id'] : '';
            $thumbnail_url    = isset( $notice['thumbnail_url'] ) ? $notice['thumbnail_url'] : '';
            $thumbnail_link   = isset( $notice['thumbnail_link'] ) ? $notice['thumbnail_link'] : '';
            $content          = isset( $notice['content'] ) ? $notice['content'] : '';
            $action_buttons   = isset( $notice['action_buttons'] ) ? $notice['action_buttons'] : array();
            $expire_timestamp = isset( $notice['expire_date'] ) ? strtotime( $notice['expire_date'] ) : '';

            $this->expire_notice_by_date( $notice_id, $expire_timestamp );

            $notice_ignore_status = $this->get_notice_status( $notice_id );

            if ( $notice_ignore_status !== 'true' && $today_timestamp <= $expire_timestamp && $this->claim_noticebar_id( $notice_id ) ) :
                ?>
                <div data-notice_id="<?php echo esc_attr( $notice_id ); ?>" id="rtmega-notice-<?php echo esc_attr( $notice_id ); ?>" class="rtmega-notice notice is-dismissible">

                    <?php if ( ! empty( $thumbnail_url ) ) : ?>
                        <?php if ( ! empty( $thumbnail_link ) ) : ?>
                            <a href="<?php echo esc_url( $thumbnail_link ); ?>" class="notice-logo-link" target="_blank" rel="noopener noreferrer" title="<?php echo esc_attr( $thumbnail_link ); ?>">
                                <img class="notice-logo" src="<?php echo esc_url( $thumbnail_url ); ?>" alt="">
                            </a>
                        <?php else : ?>
                            <img class="notice-logo" src="<?php echo esc_url( $thumbnail_url ); ?>" alt="">
                        <?php endif; ?>
                    <?php endif; ?>

                    <div class="notice-right-container">
                        <div class="notice-contents">
                            <?php echo wp_kses_post( $content ); ?>
                        </div>

                        <div class="rtmega-notice-action-buttons">
                            <?php if ( ! empty( $action_buttons ) ) : ?>
                                <?php foreach ( $action_buttons as $button ) :
                                    $action_url   = isset( $button['url'] ) ? $button['url'] : '';
                                    $action_title = isset( $button['title'] ) ? $button['title'] : '';
                                    if ( empty( $action_url ) ) {
                                        continue;
                                    }
                                    ?>
                                    <a href="<?php echo esc_url( $action_url ); ?>" class="rtmega-notice-button" target="_blank">
                                        <?php echo esc_html( $action_title ); ?>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <button type="button" class="rtmega-notice-maybe-later" data-notice_id="<?php echo esc_attr( $notice_id ); ?>"><?php esc_html_e( 'Maybe Later', 'rt-mega-menu' ); ?></button>
                        </div>

                    </div>

                    <div style="clear:both"></div>
                </div>
                <?php
            endif;
        }
    }

    public function RTMEGA_notice_add_to_dashboard_widget() {

        if ( ! isset( $GLOBALS['thewtmc_widget_claims'] ) ) {
            $GLOBALS['thewtmc_widget_claims'] = array(); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- Intentionally shared cross-plugin claim pool; must use the same name across ThemeWant plugins.
        }

        $notices         = $this->fetch_widget_notices_once();
        $today_timestamp = strtotime( gmdate( 'Y-m-d' ) );

        foreach ( $notices as $notice ) {
            $id = isset( $notice['notice_id'] ) ? $notice['notice_id'] : '';
            if ( empty( $id ) || isset( $GLOBALS['thewtmc_widget_claims'][ $id ] ) ) {
                continue;
            }
            $expire_ts = isset( $notice['expire_date'] ) ? strtotime( $notice['expire_date'] ) : 0;
            if ( $today_timestamp > $expire_ts ) {
                continue;
            }
            if ( $this->get_notice_status( $id ) === 'true' ) {
                continue;
            }
            $GLOBALS['thewtmc_widget_claims'][ $id ] = true; // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- Intentionally shared cross-plugin claim pool; must use the same name across ThemeWant plugins.
            $this->my_widget_notice_ids[ $id ]       = true;
        }

        if ( empty( $this->my_widget_notice_ids ) ) {
            return;
        }

        wp_add_dashboard_widget(
            'RTMEGA_notice_widget',
            'ThemeWant Stories',
            array( $this, 'RTMEGA_notice_widget_callback' ),
            null,
            null,
            'normal',
            'high'
        );

        global $wp_meta_boxes;

        if ( ! isset( $wp_meta_boxes['dashboard']['normal']['high']['RTMEGA_notice_widget'] ) ) {
            return;
        }

        $my_widget = array(
            'RTMEGA_notice_widget' => $wp_meta_boxes['dashboard']['normal']['high']['RTMEGA_notice_widget'],
        );

        unset( $wp_meta_boxes['dashboard']['normal']['high']['RTMEGA_notice_widget'] );

        $wp_meta_boxes['dashboard']['normal']['high'] =
            $my_widget + $wp_meta_boxes['dashboard']['normal']['high'];
    }

    public function RTMEGA_notice_widget_callback() {

        $all_notice = $this->fetch_widget_notices_once();

        if ( empty( $all_notice ) || empty( $this->my_widget_notice_ids ) ) {
            echo '<p class="rtmega-notice-widget-empty">' . esc_html__( 'No stories available right now.', 'rt-mega-menu' ) . '</p>';
            return;
        }

        $today_date      = gmdate( 'Y-m-d' );
        $today_timestamp = strtotime( $today_date );

        echo '<div class="rtmega-notice-widget">';

        foreach ( $all_notice as $notice ) {

            $notice_id        = isset( $notice['notice_id'] ) ? $notice['notice_id'] : '';
            $sub_title        = isset( $notice['sub_title'] ) ? $notice['sub_title'] : '';
            $thumbnail_url    = isset( $notice['thumbnail_url'] ) ? $notice['thumbnail_url'] : '';
            $thumbnail_link   = isset( $notice['thumbnail_link'] ) ? $notice['thumbnail_link'] : '';
            $content          = isset( $notice['content'] ) ? $notice['content'] : '';
            $action_buttons   = isset( $notice['action_buttons'] ) ? $notice['action_buttons'] : array();
            $expire_timestamp = isset( $notice['expire_date'] ) ? strtotime( $notice['expire_date'] ) : '';

            if ( empty( $sub_title ) ) {
                $sub_title = $this->get_active_plugin_display_name();
            }

            $this->expire_notice_by_date( $notice_id, $expire_timestamp );

            if ( ! isset( $this->my_widget_notice_ids[ $notice_id ] ) ) {
                continue;
            }

            $notice_ignore_status = $this->get_notice_status( $notice_id );

            if ( $notice_ignore_status !== 'true' && $today_timestamp <= $expire_timestamp ) :
                ?>
                <div class="rtmega-notice-widget-card">

                    <?php if ( ! empty( $sub_title ) ) : ?>
                        <div class="rtmega-notice-widget-eyebrow"><?php echo esc_html( $sub_title ); ?></div>
                    <?php endif; ?>

                    <?php if ( ! empty( $thumbnail_url ) ) : ?>
                        <div class="rtmega-notice-widget-thumb<?php echo ! empty( $thumbnail_link ) ? ' has-link' : ''; ?>">
                            <?php if ( ! empty( $thumbnail_link ) ) : ?>
                                <a href="<?php echo esc_url( $thumbnail_link ); ?>" class="rtmega-notice-widget-thumb-link" target="_blank" rel="noopener noreferrer">
                                    <img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="">
                                    <span class="rtmega-notice-widget-thumb-overlay">
                                        <span class="rtmega-notice-widget-thumb-overlay-text">
                                            <span class="dashicons dashicons-external" aria-hidden="true"></span>
                                        </span>
                                    </span>
                                </a>
                            <?php else : ?>
                                <img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="">
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( ! empty( $content ) ) : ?>
                        <div class="rtmega-notice-widget-content">
                            <?php echo wp_kses_post( $content ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( ! empty( $action_buttons ) ) : ?>
                        <div class="rtmega-notice-widget-actions">
                            <?php foreach ( $action_buttons as $button ) :
                                $action_url   = isset( $button['url'] ) ? $button['url'] : '';
                                $action_title = isset( $button['title'] ) ? $button['title'] : '';
                                if ( empty( $action_url ) ) {
                                    continue;
                                }
                                ?>
                                <a href="<?php echo esc_url( $action_url ); ?>" class="rtmega-notice-widget-action" target="_blank" rel="noopener noreferrer">
                                    <span class="rtmega-notice-widget-action-text"><?php echo esc_html( $action_title ); ?></span>
                                    <span aria-hidden="true" class="dashicons dashicons-external"></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </div>
                <?php
            endif;
        }

        echo '</div>';
    }
}
if ( is_admin() ) {
    new RTMEGA_NoticeDashboard();
}
<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class RTMEGA_MENU {
	
    private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Elementor_Test_Extension An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {
		if( function_exists( 'register_block_type' ) ){
			add_theme_support( 'menus' );
		}

		// Add Plugin actions
		add_action( 'elementor/widgets/register', [ $this, 'init_widgets' ] );
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_category' ] );
		add_filter( 'plugin_action_links_' . RTMEGA_MENU_PLUGIN_BASE, [ $this, 'rtmega_plugin_action_links' ], 10, 4 );

	}

	public function rtmega_plugin_action_links( $plugin_actions, $plugin_file, $plugin_data, $context ) {

		$new_actions = array();
		/* translators: 1: Settings Text */
		$new_actions['rtmega_plugin_actions_setting'] = sprintf( __( '<a href="%s" target="_self">Settings</a>', 'rt-mega-menu' ), esc_url( admin_url( 'options-general.php?page=rt-mega-menu' ) ) );
		
		/* translators: 1: Upgrade to pro text. */
		$new_actions['rtmega_plugin_actions_upgrade'] = sprintf( __( '<a href="%s" style="color: #39b54a; font-weight: bold;"  target="_blank">Upgrade to Pro</a>', 'rt-mega-menu' ), esc_url( 'https://rtmega.themewant.com' ) );
		return array_merge( $new_actions, $plugin_actions );

	}
	

    // Add elementor widget category
	public function add_category( $elements_manager ) {
        $elements_manager->add_category(
            'rtmega_category',
            [
                'title' => esc_html__('RTMEGA Elementor Addons', 'rt-mega-menu' ),
                'icon' => 'fa fa-smile-o',
            ]
        );
    }

    public function init_widgets() {
		//Nav Widget
        require_once ( RTMEGA_MENU_PL_PATH.'/public/widgets/rtmega-widget.php' );
		\Elementor\Plugin::instance()->widgets_manager->register( new \RTMEGA_MENU_INLINE() );	

		// Register widget				
		add_action( 'elementor/elements/categories_registered', [$this, 'add_category'] );
	}

	

}
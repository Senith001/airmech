<?php function reactheme_plugin_update_check($transient) {
    // Check if the transient already contains update data for our plugin
    if (empty($transient->checked)) {
        return $transient;
    }

    // Your plugin slug and URL to check for the latest version info
    $plugin_slug = 'rt-elements';
    $update_url = 'https://themewant.com/products/plugins/coolair/version-check.json';

    // Get current plugin version
    $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin_slug . '/' . $plugin_slug . '.php');
    $current_version = $plugin_data['Version'];

    // Request the latest version info from your server
    $response = wp_remote_get($update_url);
    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) != 200) {
        return $transient; // Exit if the request fails
    }

    $remote_data = json_decode(wp_remote_retrieve_body($response));

    if (!is_object($remote_data) || empty($remote_data->new_version)) {
        return $transient;
    }

    if (version_compare($current_version, $remote_data->new_version, '<')) {
        $transient->response[$plugin_slug . '/' . $plugin_slug . '.php'] = (object) [
            'id'          => $plugin_slug . '/' . $plugin_slug . '.php',
            'slug'        => $plugin_slug,
            'plugin'      => $plugin_slug . '/' . $plugin_slug . '.php',
            'new_version' => $remote_data->new_version,
            'url'         => isset($remote_data->changelog) ? $remote_data->changelog : '',
            'package'     => isset($remote_data->download_url) ? $remote_data->download_url : '',
        ];
    }

    return $transient;
}
add_filter('pre_set_site_transient_update_plugins', 'reactheme_plugin_update_check');

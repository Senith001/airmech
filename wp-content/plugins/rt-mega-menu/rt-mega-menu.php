<?php
/**
 * Plugin Name: RT Mega Menu
 * Description: Elementor Page Builder supported mega menu builder. You make any type of mega menu by using this plugin.
 * Plugin URI:  https://rtmega.themewant.com/
 * Author:      Themewant
 * Author URI:  http://themewant.com/
 * Version:     1.5.3
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: rt-mega-menu
 * Domain Path: /languages
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'RTMEGA_MENU_VERSION', '1.5.3' );
define( 'RTMEGA_MENU_PL_ROOT', __FILE__ );
define( 'RTMEGA_MENU_PL_URL', plugins_url( '/', RTMEGA_MENU_PL_ROOT ) );
define( 'RTMEGA_MENU_PL_PATH', plugin_dir_path( RTMEGA_MENU_PL_ROOT ) );
define( 'RTMEGA_MENU_DIR_URL', plugin_dir_url( RTMEGA_MENU_PL_ROOT ) );
define( 'RTMEGA_MENU_PLUGIN_BASE', plugin_basename( RTMEGA_MENU_PL_ROOT ) );
define( 'RTMEGA_MENU_NAME', 'RTMEGA Menu' );

include 'admin/includes/admin-settings.php';
include 'admin/includes/post-types.php';
include 'admin/includes/menu-metabox.php';
include 'admin/includes/plugin-scripts.php';
include 'admin/includes/admin-ajax-request.php';
include 'admin/includes/NoticeDashboard/NoticeDashboard.php';

include 'public/includes/plugin-scripts.php';
include 'public/includes/rtmega-nav-walker.php';
include 'public/includes/rt-mega-menu-terms.php';
include 'public/includes/rtmega-dynamic-css.php';
include 'public/includes/class.helper.php';
include 'admin/includes/template-library.php';
include 'class.rtmega-menu.php';
include 'public/blocks/blocks.php';

include 'apps/vendor/autoload.php';
include 'apps/Appsero_Tracker.php';

RTMEGA_MENU::instance();
if ( class_exists( '\RtMega\MegaMenu\Tracking\Appsero_Tracker' ) ) {
    \RtMega\MegaMenu\Tracking\Appsero_Tracker::instance();
}
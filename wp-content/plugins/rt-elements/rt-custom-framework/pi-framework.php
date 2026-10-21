<?php
// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    die( 'You shouldnt be here' );
}

/**
* Function when plugin is activated
*
* @param void
*
*/
//Including file that manages all template

//All Post type include here

$dir = plugin_dir_path( __FILE__ );
//For team
require_once $dir .'/metaboxes/page-header.php';
require_once $dir .'/metaboxes/custom-metabox.php';
require_once $dir .'/metaboxes/cmb2/init.php';

/**
 * Implement widgets
 */
require_once $dir . '/widgets/post_recent_widget.php';
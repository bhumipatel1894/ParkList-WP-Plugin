<?php
/**
 * Plugin Name: Parks Directory
 * Plugin URL: https://github.com/bhumipatel1894/ParkList-WP-Plugin
 * Text Domain: parks-directory
 * Domain Path: /languages/
 * Description: This plugin allows you to create Parks Directory and display Park list with park facilities.
 * Version: 1.0.0
 * Author: Bhumi patel
 * Author URI: https://profiles.wordpress.org/bhumipatel1894/
 * 
 * @package Parks Directory
 * @author Bhumi patel
*/

if ( ! defined( constant_name: 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if( ! defined( 'PD_VERSION' ) ) {
	define( 'PD_VERSION', '1.0.0' ); // Version of plugin
}

if( ! defined( 'PD_DIR' ) ) {
	define( 'PD_DIR', dirname( __FILE__ ) ); // Plugin dir
}

if( ! defined( 'PD_URL' ) ) {
	define( 'PD_URL', plugin_dir_url( __FILE__ ) ); // Plugin url
}

if( ! defined( 'PD_POST_TYPE' ) ) {
	define( 'PD_POST_TYPE', 'Parks' ); // Plugin post type
}

if( ! defined( 'PD_CAT' ) ) {
	define( 'PD_CAT', 'facilities' ); // Plugin category name
}


/**
 * Activation Hook
 * 
 * Register plugin activation hook.
 * 
 * @since 1.0.0
 */
register_activation_hook( __FILE__, 'pd_install' );

/**
 * Deactivation Hook
 * 
 * Register plugin deactivation hook.
 * 
 * @since 1.0.0
 */
register_deactivation_hook( __FILE__, 'pd_uninstall');

/**
 * Plugin Setup (On Activation)
 * 
 * Does the initial setup,
 * stest default values for the plugin options.
 * 
 * @since 1.0.0
 */
function pd_install() {

	pd_register_post_type();
	pd_register_taxonomies();

	// IMP need to flush rules for custom registered post type
	flush_rewrite_rules();

}

/**
 * Plugin Setup (On Deactivation)
 * 
 * Delete  plugin options.
 *
 * @since 1.0.0
 */
function pd_uninstall() {

	// IMP need to flush rules for custom registered post type
	flush_rewrite_rules();
}

// Function File
require_once( PD_DIR . '/includes/parks-functions.php' );

// Custom Post Type File
require_once( PD_DIR . '/includes/cpt-parks.php' );

// Admin Class File
require_once( PD_DIR . '/includes/admin/class-parks-admin.php' );

// Shortcode File
require_once( PD_DIR . '/includes/shortcode/parks-list-shortcode.php' );
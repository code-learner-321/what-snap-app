<?php
/**
 * Plugin Name:       What Snap App
 * Description:       Example block scaffolded with Create Block tool.
 * Version:           0.1.0
 * Requires at least: 6.8
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       what-snap-app
 *
 * @package CreateBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function create_block_what_snap_app_block_init() {
	wp_register_block_types_from_metadata_collection( __DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php' );
}
add_action( 'init', 'create_block_what_snap_app_block_init' );


// Enqueue scripts and styles for elementor code pattern scaffold plugin......
// function elementor_code_pattern_enqueue_scripts() {
//     // Make sure jQuery is loaded
//     wp_enqueue_script('jquery');
    
//     // Enqueue our custom script
//     wp_enqueue_script(
//         'elementor-code-pattern-script',
//         plugin_dir_url(__FILE__) . 'assets/js/my-jquery.js',
//         array('jquery'),
//         '1.0.0',
//         true
//     );
//     wp_enqueue_style(
//         'elementor-code-pattern-style',
//         plugin_dir_url(__FILE__) . 'assets/css/my-style.css',
//         array(),
//         '1.0.0'
//     );
    
// }
// add_action('wp_enqueue_scripts', 'elementor_code_pattern_enqueue_scripts', 20);

function elementor_code_pattern_addon() {
    require_once( __DIR__ . '/includes/plugin.php' );
    \Elementor_Code_Pattern_Addon\Plugin::instance();
}
add_action( 'plugins_loaded', 'elementor_code_pattern_addon' );
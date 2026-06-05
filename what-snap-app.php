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

// admin page.............

// Settings Page Setup
add_action('admin_menu', 'wsa_add_admin_menu');
function wsa_add_admin_menu() {
    add_menu_page('What Snap App', 'What Snap App', 'manage_options', 'what-snap-app', 'wsa_options_page', 'dashicons-whatsapp', 90);
}

add_action('admin_init', 'wsa_register_settings');
function wsa_register_settings() {
    register_setting('wsa_options_group', 'wsa_phone_number');
    register_setting('wsa_options_group', 'wsa_bg_color');
    register_setting('wsa_options_group', 'wsa_text_color');
    register_setting('wsa_options_group', 'wsa_icon_size');
}

function wsa_options_page() {
    ?>
    <div class="wrap">
        <h1>What Snap App Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('wsa_options_group'); ?>
            <table class="form-table">
                <tr><th>Phone Number (with country code)</th><td><input type="text" name="wsa_phone_number" value="<?php echo esc_attr(get_option('wsa_phone_number', '1234567890')); ?>" /></td></tr>
                <tr><th>Button BG Color</th><td><input type="color" name="wsa_bg_color" value="<?php echo esc_attr(get_option('wsa_bg_color', '#25D366')); ?>" /></td></tr>
                <tr><th>Text Color</th><td><input type="color" name="wsa_text_color" value="<?php echo esc_attr(get_option('wsa_text_color', '#ffffff')); ?>" /></td></tr>
                <tr><th>Icon Size (px)</th><td><input type="number" name="wsa_icon_size" value="<?php echo esc_attr(get_option('wsa_icon_size', '30')); ?>" /></td></tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Inject Dynamic CSS to Front-End
add_action('wp_head', 'wsa_inject_dynamic_css');
function wsa_inject_dynamic_css() {
    $bg = get_option('wsa_bg_color', '#25D366');
    $text = get_option('wsa_text_color', '#ffffff');
    $size = get_option('wsa_icon_size', '30');
    echo "<style>
        .whatsapp-btn { background-color: {$bg} !important; color: {$text} !important; }
        .whatsapp-icon { width: {$size}px !important; height: {$size}px !important; }
    </style>";
}

// Pass settings to the block editor
add_action('enqueue_block_editor_assets', 'wsa_enqueue_block_editor_assets');
function wsa_enqueue_block_editor_assets() {
    $settings = [
        'bg_color'   => get_option('wsa_bg_color', '#25D366'),
        'text_color' => get_option('wsa_text_color', '#ffffff'),
        'icon_size'  => get_option('wsa_icon_size', '30') . 'px',
    ];
    wp_add_inline_script(
        'what-snap-app-editor-script', // Replace with your actual editor script handle
        'window.wsaGlobalSettings = ' . json_encode($settings) . ';'
    );
}

// Register a REST API route to fetch settings
add_action('rest_api_init', function () {
    register_rest_route('wsa/v1', '/settings', [
        'methods' => 'GET',
        'callback' => function() {
            return [
                'bg_color'   => get_option('wsa_bg_color', '#25D366'),
                'text_color' => get_option('wsa_text_color', '#ffffff'),
                'icon_size'  => get_option('wsa_icon_size', '30') . 'px',
            ];
        },
        'permission_callback' => '__return_true'
    ]);
});
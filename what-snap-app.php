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
    register_setting('wsa_options_group', 'wsa_button_text'); // New
}

function wsa_options_page() {
    ?>
    <div class="wrap">
        <h1>WhatsApp Button Settings</h1>
        <form method="post" action="options.php" style="display: flex; gap: 40px; align-items: flex-start; margin-top: 20px;">
            <?php settings_fields('wsa_options_group'); ?>
            
            <div style="background: #fff; padding: 25px; border-radius: 8px; border: 1px solid #ccc; width: 100%; max-width: 500px;">
                <style>
                    .wsa-table th { width: 150px; text-align: left; padding: 15px 0 !important; }
                    .wsa-table td { padding: 10px 0 !important; }
                    .wsa-table input { width: 100%; }
                </style>
                <table class="form-table wsa-table">
                    <tr><th>Phone Number</th><td><input type="text" id="wsa_phone" name="wsa_phone_number" value="<?php echo esc_attr(get_option('wsa_phone_number', '1234567890')); ?>" /></td></tr>
                    <tr><th>Button Text</th><td><input type="text" id="wsa_text_input" name="wsa_button_text" value="<?php echo esc_attr(get_option('wsa_button_text', 'Chat on WhatsApp')); ?>" /></td></tr>
                    <tr><th>BG Color</th><td><input type="color" id="wsa_bg" name="wsa_bg_color" value="<?php echo esc_attr(get_option('wsa_bg_color', '#25D366')); ?>" /></td></tr>
                    <tr><th>Text Color</th><td><input type="color" id="wsa_text" name="wsa_text_color" value="<?php echo esc_attr(get_option('wsa_text_color', '#ffffff')); ?>" /></td></tr>
                    <tr><th>Icon Size (px)</th><td><input type="number" id="wsa_size" name="wsa_icon_size" value="<?php echo esc_attr(get_option('wsa_icon_size', '30')); ?>" /></td></tr>
                </table>
                <?php submit_button(); ?>
            </div>

            <div style="background: #f9f9f9; padding: 30px; border: 1px solid #ddd; border-radius: 8px; flex: 1; text-align: center;">
                <h3>Live Preview</h3>
                <a href="#" id="live-whatsapp-btn" style="display: inline-flex; align-items: center; gap: 10px; padding: 12px 20px; border-radius: 50px; text-decoration: none; font-weight: 600; background-color: <?php echo esc_attr(get_option('wsa_bg_color', '#25D366')); ?>; color: <?php echo esc_attr(get_option('wsa_text_color', '#ffffff')); ?>;">
                    <svg id="live-whatsapp-icon" viewBox="0 0 60 60" style="width: <?php echo esc_attr(get_option('wsa_icon_size', '30')); ?>px; height: <?php echo esc_attr(get_option('wsa_icon_size', '30')); ?>px; fill: <?php echo esc_attr(get_option('wsa_text_color', '#ffffff')); ?>;">
                        <path d="M29.99 0C13.45 0 0 13.45 0 30c0 6.56 2.12 12.65 5.71 17.58L1.97 58.73l11.53-3.69C18.25 58.18 23.91 60 30 60c16.54 0 30-13.45 30-30C60 13.45 46.54 0 30 0zm0 54.55c-5.1 0-9.92-1.3-14.15-3.58l-1.02-.58-3.59 1.15 1.15-3.59-.58-1.02c-2.28-4.23-3.58-9.05-3.58-14.15 0-13.25 10.75-24 24-24s24 10.75 24 24-10.75 24-24 24zM43.7 39.8c-.37-.18-2.2-1.08-2.54-1.21-.34-.13-.59-.19-.84.19-.25.38-1 1.21-1.23 1.47-.23.25-.45.28-.82.09-.37-.18-1.57-.58-2.99-1.85-1.1-1-1.85-2.22-2.07-2.6-.22-.38-.02-.58.17-.77.18-.18.38-.47.57-.71.19-.23.25-.4.37-.65.13-.25.06-.47-.03-.66s-.84-2.02-1.15-2.77c-.29-.71-.59-.62-.81-.63-.21-.01-.45-.01-.69-.01-.24 0-.63.09-.96.47-.32.38-1.23 1.2-1.23 2.92s1.26 3.39 1.44 3.63c.18.25 2.5 3.81 6.07 5.34 3.56 1.53 3.56 1.02 4.2.96.64-.06 2.08-.85 2.37-1.67.29-.82.29-1.52.2-1.67-.09-.15-.34-.24-.71-.42z"/>
                    </svg>
                    <span id="live-button-text"><?php echo esc_html(get_option('wsa_button_text', 'Chat on WhatsApp')); ?></span>
                </a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bgInput = document.getElementById('wsa_bg');
            const textInput = document.getElementById('wsa_text');
            const sizeInput = document.getElementById('wsa_size');
            const labelInput = document.getElementById('wsa_text_input');
            const btn = document.getElementById('live-whatsapp-btn');
            const icon = document.getElementById('live-whatsapp-icon');
            const btnText = document.getElementById('live-button-text');

            function updatePreview() {
                btn.style.backgroundColor = bgInput.value;
                btn.style.color = textInput.value;
                icon.style.width = sizeInput.value + 'px';
                icon.style.height = sizeInput.value + 'px';
                icon.style.fill = textInput.value;
                btnText.textContent = labelInput.value;
            }
            [bgInput, textInput, sizeInput, labelInput].forEach(el => el.addEventListener('input', updatePreview));
        });
    </script>
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
// In what-snap-app.php
add_action('rest_api_init', function () {
    register_rest_route('wsa/v1', '/settings', [
        'methods' => 'GET',
        'callback' => function() {
            return [
                'bg_color'    => get_option('wsa_bg_color', '#25D366'),
                'text_color'  => get_option('wsa_text_color', '#ffffff'),
                'icon_size'   => get_option('wsa_icon_size', '30'),
                'button_text' => get_option('wsa_button_text', 'Chat on WhatsApp')
            ];
        },
        'permission_callback' => '__return_true' // Ensure this is accessible
    ]);
});
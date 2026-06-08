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

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function create_block_what_snap_app_block_init()
{
    wp_register_block_types_from_metadata_collection(__DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php');
}
add_action('init', 'create_block_what_snap_app_block_init');

function elementor_code_pattern_addon()
{
    require_once(__DIR__ . '/includes/plugin.php');
    \Elementor_Code_Pattern_Addon\Plugin::instance();
}
add_action('plugins_loaded', 'elementor_code_pattern_addon');

// Settings Page Setup
add_action('admin_menu', 'wsa_add_admin_menu');
function wsa_add_admin_menu()
{
    add_menu_page('What Snap App', 'What Snap App', 'manage_options', 'what-snap-app', 'wsa_options_page', 'dashicons-whatsapp', 90);
}

add_action('admin_init', 'wsa_register_settings');
function wsa_register_settings()
{
    register_setting('wsa_options_group', 'wsa_phone_number');
    register_setting('wsa_options_group', 'wsa_bg_color');
    register_setting('wsa_options_group', 'wsa_text_color');
    register_setting('wsa_options_group', 'wsa_icon_size');
    register_setting('wsa_options_group', 'wsa_button_text');
    register_setting('wsa_options_group', 'wsa_icon_bg_color');
}

function wsa_options_page()
{
?>
    <div class="wrap">
        <h1>What Snap App Button Settings</h1>
        <form method="post" action="options.php" style="display: flex; gap: 40px; align-items: flex-start; margin-top: 20px;">
            <?php settings_fields('wsa_options_group'); ?>

            <div style="background: #fff; padding: 25px; border-radius: 8px; border: 1px solid #ccc; width: 100%; max-width: 500px;">
                <table class="form-table wsa-table">
                    <tr>
                        <th>Phone Number</th>
                        <td><input type="text" name="wsa_phone_number" value="<?php echo esc_attr(get_option('wsa_phone_number', '1234567890')); ?>" /></td>
                    </tr>
                    <tr>
                        <th>Button Text</th>
                        <td><input type="text" id="wsa_text_input" name="wsa_button_text" value="<?php echo esc_attr(get_option('wsa_button_text', 'Chat on WhatsApp')); ?>" /></td>
                    </tr>
                    <tr>
                        <th>BG Color</th>
                        <td><input type="color" id="wsa_bg" name="wsa_bg_color" value="<?php echo esc_attr(get_option('wsa_bg_color', '#25D366')); ?>" /></td>
                    </tr>
                    <tr>
                        <th>Text Color</th>
                        <td><input type="color" id="wsa_text" name="wsa_text_color" value="<?php echo esc_attr(get_option('wsa_text_color', '#ffffff')); ?>" /></td>
                    </tr>
                    <tr>
                        <th>Icon BG Color</th>
                        <td><input type="color" id="wsa_icon_bg" name="wsa_icon_bg_color" value="<?php echo esc_attr(get_option('wsa_icon_bg_color', '#ffffff')); ?>" /></td>
                    </tr>
                    <tr>
                        <th>Icon Size (px)</th>
                        <td><input type="number" id="wsa_size" name="wsa_icon_size" value="<?php echo esc_attr(get_option('wsa_icon_size', '30')); ?>" /></td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </div>

            <div style="background: #f9f9f9; padding: 30px; border: 1px solid #ddd; border-radius: 8px; flex: 1; text-align: center;">
                <h3>Live Preview</h3>

                <a href="#" id="live-whatsapp-btn" class="whatsapp-btn" style="
                    display: inline-flex; 
                    align-items: center; 
                    gap: 10px; 
                    padding: 12px 20px; 
                    border-radius: 50px; 
                    text-decoration: none; 
                    background-color: <?php echo esc_attr(get_option('wsa_bg_color', '#25D366')); ?>; 
                    color: <?php echo esc_attr(get_option('wsa_text_color', '#ffffff')); ?>;
                ">
                    <span id="live-icon-wrapper" class="whatsapp-icon-wrapper" style="
                        display: flex; 
                        align-items: center; 
                        justify-content: center; 
                    ">
                        <svg id="live-whatsapp-icon" class="whatsapp-icon" style="
                            width: <?php echo esc_attr(get_option('wsa_icon_size', '30')); ?>px; 
                            height: <?php echo esc_attr(get_option('wsa_icon_size', '30')); ?>px;
                        " viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg">
                            <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M29.9913 0C13.4528 0 0 13.4566 0 29.9997C0 36.5605 2.1158 42.645 5.71251 47.5837L1.97449 58.7297L13.5056 55.0444C18.2482 58.1837 23.908 60 30.0087 60C46.5472 60 60 46.5429 60 30.0003C60 13.4571 46.5472 0.000495911 30.0087 0.000495911L29.9913 0ZM21.6161 15.2385C21.0344 13.8453 20.5935 13.7926 19.7122 13.7568C19.4122 13.7393 19.0778 13.7219 18.707 13.7219C17.5606 13.7219 16.3618 14.0569 15.6388 14.7976C14.7575 15.697 12.571 17.7955 12.571 22.099C12.571 26.4025 15.7095 30.5647 16.1324 31.147C16.5733 31.7284 22.251 40.6879 31.0666 44.3394C37.9604 47.1964 40.0061 46.9316 41.5751 46.5966C43.8671 46.1029 46.7413 44.4091 47.4643 42.3638C48.1873 40.3176 48.1873 38.5715 47.9753 38.2011C47.7638 37.8308 47.1816 37.6198 46.3004 37.1783C45.4191 36.7373 41.1342 34.6208 40.3231 34.3386C39.5294 34.039 38.7716 34.145 38.1725 34.9916C37.326 36.1733 36.4975 37.3729 35.8273 38.0956C35.2983 38.6601 34.4339 38.7307 33.7114 38.4306C32.7416 38.0254 30.0266 37.0722 26.6763 34.0917C24.0842 31.7817 22.3212 28.9072 21.8102 28.0431C21.2986 27.1616 21.7573 26.6494 22.1624 26.1736C22.6033 25.6265 23.0263 25.2388 23.4672 24.7271C23.9081 24.2159 24.1549 23.9511 24.437 23.3513C24.7371 22.7695 24.5251 22.1697 24.3136 21.7287C24.1021 21.2877 22.3391 16.9841 21.6161 15.2385Z"
                                fill="<?php echo esc_attr(get_option('wsa_icon_bg_color', '#ffffff')); ?>" />
                        </svg>
                    </span>
                    <span id="live-button-text"><?php echo esc_html(get_option('wsa_button_text', 'Chat on WhatsApp')); ?></span>
                </a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bgInput = document.getElementById('wsa_bg');
            const iconBgInput = document.getElementById('wsa_icon_bg');
            const textInput = document.getElementById('wsa_text');
            const sizeInput = document.getElementById('wsa_size');
            const labelInput = document.getElementById('wsa_text_input');
            
            const btn = document.getElementById('live-whatsapp-btn');
            const iconWrapper = document.getElementById('live-icon-wrapper');
            const icon = document.getElementById('live-whatsapp-icon');
            const btnText = document.getElementById('live-button-text');

            function updatePreview() {
                btn.style.backgroundColor = bgInput.value;
                btn.style.color = textInput.value;
                icon.style.width = sizeInput.value + 'px';
                icon.style.height = sizeInput.value + 'px';
                
                // Target the path element inside the SVG
                const path = icon.querySelector('path');
                if (path) {
                    path.setAttribute('fill', iconBgInput.value);
                }
                
                btnText.textContent = labelInput.value;
            }
            [bgInput, iconBgInput, textInput, sizeInput, labelInput].forEach(el => el.addEventListener('input', updatePreview));
        });
    </script>
<?php
}

// Inject Dynamic CSS to Front-End
add_action('wp_head', 'wsa_inject_dynamic_css');
function wsa_inject_dynamic_css()
{
    $bg   = get_option('wsa_bg_color', '#25D366');
    $text = get_option('wsa_text_color', '#ffffff');
    $size = get_option('wsa_icon_size', '30');
    echo "<style>
        .whatsapp-btn { background-color: {$bg} !important; color: {$text} !important; }
        .whatsapp-icon-wrapper { border-radius: 50%; display: inline-flex; padding: 5px; }
        .whatsapp-icon { width: {$size}px !important; height: {$size}px !important; fill: {$text} !important; }
    </style>";
}

// Pass settings to the block editor
add_action('enqueue_block_editor_assets', 'wsa_enqueue_block_editor_assets');
function wsa_enqueue_block_editor_assets()
{
    $settings = [
        'bg_color'   => get_option('wsa_bg_color', '#25D366'),
        'text_color' => get_option('wsa_text_color', '#ffffff'),
        'icon_size'  => get_option('wsa_icon_size', '30') . 'px',
    ];
    wp_add_inline_script(
        'what-snap-app-editor-script', 
        'window.wsaGlobalSettings = ' . json_encode($settings) . ';'
    );
}

// Register a REST API route to fetch settings
add_action('rest_api_init', function () {
    register_rest_route('wsa/v1', '/settings', [
        'methods' => 'GET',
        'callback' => function () {
            return [
                'bg_color'    => get_option('wsa_bg_color', '#25D366'),
                'text_color'  => get_option('wsa_text_color', '#ffffff'),
                'icon_size'   => get_option('wsa_icon_size', '30'),
                'button_text' => get_option('wsa_button_text', 'Chat on WhatsApp'),
                'icon_bg_color'  => get_option('wsa_icon_bg_color', '#ffffff')
            ];
        },
        'permission_callback' => '__return_true'
    ]);
});
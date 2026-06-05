<?php

namespace Elementor_Code_Pattern_Addon;

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;

class Elementor_Code_Scaffold extends Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
    }

    public function get_script_depends()
    {
        return ['jquery', 'elementor-code-pattern-script'];
    }
    public function get_style_depends()
    {
        return ['elementor-code-pattern-style'];
    }
    public function get_name()
    {
        return 'code-pattern-widget';
    }

    public function get_title()
    {
        return \esc_html__('Code Pattern Widget', 'json-pagenation');
    }

    public function get_icon()
    {
        return 'eicon-inner-section';
    }

    public function get_keywords(): array
    {
        return ['code', 'pattern'];
    }

    public function get_categories()
    {
        return ['general'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Settings', 'custom-elementor-widget' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'limit',
            [
                'label' => esc_html__( 'Limit', 'custom-elementor-widget' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 10,
            ]
        );
        

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div>
            <h1>Hi</h1>
        </div>
        <?php
            
    }

}

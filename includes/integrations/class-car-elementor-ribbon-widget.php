<?php
if (!defined('ABSPATH')) exit;

if (!class_exists('\Elementor\Widget_Base')) return;

class CAR_Elementor_Ribbon_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'car_awareness_ribbon';
    }

    public function get_title()
    {
        return 'Awareness Ribbon';
    }

    public function get_icon()
    {
        return 'eicon-heart';
    }

    public function get_categories()
    {
        return ['general'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'car_section_content',
            [
                'label' => 'Ribbon',
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'type',
            [
                'label' => 'Ribbon Type',
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array_merge(['' => 'Auto (Featured / Month)'], car_get_awareness_types_select_options_flat()),
                'default' => '',
            ]
        );

        $month_options = [
            ''  => 'Auto (Current Month)',
            '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ];

        $this->add_control(
            'month',
            [
                'label' => 'Month',
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $month_options,
                'default' => '',
            ]
        );

        $this->add_control(
            'size',
            [
                'label' => 'Size (px)',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min' => 16, 'max' => 512],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 64,
                ],
            ]
        );

        $this->add_control(
            'label',
            [
                'label' => 'Show Label',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'Yes',
                'label_off' => 'No',
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->add_control(
            'category',
            [
                'label' => 'Category Filter',
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '' => 'All',
                    'Cancer' => 'Cancer',
                    'Medical' => 'Medical',
                    'Social' => 'Social',
                    'Global' => 'Global',
                ],
                'default' => '',
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => 'List Mode (show all ribbons for month)',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'On',
                'label_off' => 'Off',
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->add_control(
            'class',
            [
                'label' => 'Extra CSS Class',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => 'my-custom-class',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $size_px = 64;
        if (isset($settings['size']['size']) && is_numeric($settings['size']['size'])) {
            $size_px = (int)$settings['size']['size'];
        }

        $atts = [
            'type'     => isset($settings['type']) ? (string)$settings['type'] : '',
            'month'    => isset($settings['month']) ? (string)$settings['month'] : '',
            'size'     => (string)car_clamp_int($size_px, 16, 512),
            'label'    => (!empty($settings['label']) && (string)$settings['label'] === '1') ? '1' : '0',
            'category' => isset($settings['category']) ? (string)$settings['category'] : '',
            'list'     => (!empty($settings['list']) && (string)$settings['list'] === '1') ? '1' : '0',
            'class'    => isset($settings['class']) ? (string)$settings['class'] : '',
        ];

        echo car_render_awareness_ribbon($atts);
    }
}

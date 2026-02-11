<?php
if (!defined('ABSPATH')) exit;

if (!class_exists('ET_Builder_Module')) return;

class CAR_Divi_Ribbon_Module extends ET_Builder_Module
{
    public $slug       = 'car_awareness_ribbon';
    public $vb_support = 'on';

    public function init()
    {
        $this->name = esc_html__('Awareness Ribbon', 'cancer-awareness-ribbon');
        $this->icon_path = ''; // optional
    }

    public function get_fields()
    {
        $type_options = ['' => esc_html__('Auto (Featured / Month)', 'cancer-awareness-ribbon')];

        if (function_exists('car_get_awareness_types_select_options_flat')) {
            $flat = car_get_awareness_types_select_options_flat(); // value => label
            foreach ($flat as $value => $label) {
                $type_options[(string)$value] = (string)$label; // Divi uses value => label
            }
        }

        return [
            'type' => [
                'label'           => esc_html__('Ribbon Type', 'cancer-awareness-ribbon'),
                'type'            => 'select',
                'options'         => $type_options,
                'default'         => '',
                'description'     => esc_html__('Choose a specific ribbon or leave on Auto.', 'cancer-awareness-ribbon'),
                'toggle_slug'     => 'main_content',
            ],
            'month' => [
                'label'       => esc_html__('Month', 'cancer-awareness-ribbon'),
                'type'        => 'select',
                'options'     => [
                    ''   => esc_html__('Auto (Current Month)', 'cancer-awareness-ribbon'),
                    '1'  => esc_html__('January', 'cancer-awareness-ribbon'),
                    '2'  => esc_html__('February', 'cancer-awareness-ribbon'),
                    '3'  => esc_html__('March', 'cancer-awareness-ribbon'),
                    '4'  => esc_html__('April', 'cancer-awareness-ribbon'),
                    '5'  => esc_html__('May', 'cancer-awareness-ribbon'),
                    '6'  => esc_html__('June', 'cancer-awareness-ribbon'),
                    '7'  => esc_html__('July', 'cancer-awareness-ribbon'),
                    '8'  => esc_html__('August', 'cancer-awareness-ribbon'),
                    '9'  => esc_html__('September', 'cancer-awareness-ribbon'),
                    '10' => esc_html__('October', 'cancer-awareness-ribbon'),
                    '11' => esc_html__('November', 'cancer-awareness-ribbon'),
                    '12' => esc_html__('December', 'cancer-awareness-ribbon'),
                ],
                'default'     => '',
                'toggle_slug' => 'main_content',
            ],
            'size' => [
                'label'           => esc_html__('Size (px)', 'cancer-awareness-ribbon'),
                'type'            => 'range',
                'range_settings'  => [
                    'min'  => 16,
                    'max'  => 512,
                    'step' => 1,
                ],
                'default'         => 64,
                'toggle_slug'     => 'main_content',
            ],
            'label' => [
                'label'           => esc_html__('Show Label', 'cancer-awareness-ribbon'),
                'type'            => 'yes_no_button',
                'options'         => [
                    'off' => esc_html__('No', 'cancer-awareness-ribbon'),
                    'on'  => esc_html__('Yes', 'cancer-awareness-ribbon'),
                ],
                'default'         => 'off',
                'toggle_slug'     => 'main_content',
            ],
            'category' => [
                'label'           => esc_html__('Category Filter', 'cancer-awareness-ribbon'),
                'type'            => 'select',
                'options'         => [
                    ''        => esc_html__('All', 'cancer-awareness-ribbon'),
                    'Cancer'  => esc_html__('Cancer', 'cancer-awareness-ribbon'),
                    'Medical' => esc_html__('Medical', 'cancer-awareness-ribbon'),
                    'Social'  => esc_html__('Social', 'cancer-awareness-ribbon'),
                    'Global'  => esc_html__('Global', 'cancer-awareness-ribbon'),
                ],
                'default'         => '',
                'toggle_slug'     => 'main_content',
            ],
            'list' => [
                'label'           => esc_html__('List Mode (show all ribbons for month)', 'cancer-awareness-ribbon'),
                'type'            => 'yes_no_button',
                'options'         => [
                    'off' => esc_html__('Off', 'cancer-awareness-ribbon'),
                    'on'  => esc_html__('On', 'cancer-awareness-ribbon'),
                ],
                'default'         => 'off',
                'toggle_slug'     => 'main_content',
            ],
            'class' => [
                'label'           => esc_html__('Extra CSS Class', 'cancer-awareness-ribbon'),
                'type'            => 'text',
                'default'         => '',
                'toggle_slug'     => 'advanced',
            ],
        ];
    }

    public function get_settings_modal_toggles()
    {
        return [
            'general' => [
                'toggles' => [
                    'main_content' => esc_html__('Ribbon', 'cancer-awareness-ribbon'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'advanced' => esc_html__('Advanced', 'cancer-awareness-ribbon'),
                ],
            ],
        ];
    }

    public function render($attrs, $content = null, $render_slug = null)
    {
        if (!function_exists('car_render_awareness_ribbon')) {
            return '';
        }

        $type = isset($this->props['type']) ? (string)$this->props['type'] : '';
        $month = isset($this->props['month']) ? (string)$this->props['month'] : '';
        $size = isset($this->props['size']) ? (int)$this->props['size'] : 64;

        $atts = [
            'type'     => $type,
            'month'    => $month,
            'size'     => (string)car_clamp_int($size, 16, 512),
            'label'    => (isset($this->props['label']) && $this->props['label'] === 'on') ? '1' : '0',
            'category' => isset($this->props['category']) ? (string)$this->props['category'] : '',
            'list'     => (isset($this->props['list']) && $this->props['list'] === 'on') ? '1' : '0',
            'class'    => isset($this->props['class']) ? (string)$this->props['class'] : '',
        ];

        return car_render_awareness_ribbon($atts);
    }
}

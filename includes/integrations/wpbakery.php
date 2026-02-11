<?php
if (!defined('ABSPATH')) exit;

/**
 * WPBakery / Visual Composer Integration
 *
 * Registers a WPBakery element that maps directly to the existing [cancer_ribbon] shortcode.
 */

/**
 * Detect WPBakery / Visual Composer.
 */
function car_wpbakery_is_active(): bool
{
    return function_exists('vc_map') || defined('WPB_VC_VERSION');
}

/**
 * Build WPBakery dropdown array in the format:
 *   [ 'Label' => 'value' ]
 */
function car_wpbakery_type_dropdown_values(): array
{
    if (!function_exists('car_get_awareness_types_select_options_flat')) return [];

    $flat = car_get_awareness_types_select_options_flat(); // value => label
    $out = ['Auto (Featured / Month)' => ''];

    foreach ($flat as $value => $label) {
        $out[(string)$label] = (string)$value;
    }

    return $out;
}

/**
 * Register the VC element. Must run on vc_before_init.
 */
function car_register_wpbakery_element(): void
{
    if (!car_wpbakery_is_active()) return;

    // Ensure core functions exist (plugin loaded fully)
    if (!function_exists('car_render_awareness_ribbon')) return;

    vc_map([
        'name'        => __('Awareness Ribbon', 'cancer-awareness-ribbon'),
        'description' => __('Displays an awareness ribbon (uses the Cancer Ribbon shortcode).', 'cancer-awareness-ribbon'),
        'base'        => 'cancer_ribbon', // map directly to your shortcode
        'category'    => __('Content', 'cancer-awareness-ribbon'),
        'icon'        => 'icon-wpb-ui-separator', // harmless default icon
        'params'      => [
            [
                'type'        => 'dropdown',
                'heading'     => __('Ribbon Type', 'cancer-awareness-ribbon'),
                'param_name'  => 'type',
                'value'       => car_wpbakery_type_dropdown_values(),
                'std'         => '',
                'description' => __('Choose a specific ribbon or leave on Auto.', 'cancer-awareness-ribbon'),
            ],
            [
                'type'        => 'dropdown',
                'heading'     => __('Month', 'cancer-awareness-ribbon'),
                'param_name'  => 'month',
                'value'       => [
                    __('Auto (Current Month)', 'cancer-awareness-ribbon') => '',
                    __('January', 'cancer-awareness-ribbon')   => '1',
                    __('February', 'cancer-awareness-ribbon')  => '2',
                    __('March', 'cancer-awareness-ribbon')     => '3',
                    __('April', 'cancer-awareness-ribbon')     => '4',
                    __('May', 'cancer-awareness-ribbon')       => '5',
                    __('June', 'cancer-awareness-ribbon')      => '6',
                    __('July', 'cancer-awareness-ribbon')      => '7',
                    __('August', 'cancer-awareness-ribbon')    => '8',
                    __('September', 'cancer-awareness-ribbon') => '9',
                    __('October', 'cancer-awareness-ribbon')   => '10',
                    __('November', 'cancer-awareness-ribbon')  => '11',
                    __('December', 'cancer-awareness-ribbon')  => '12',
                ],
                'std'         => '',
                'description' => __('Overrides the month for selection/listing. Auto uses the current month.', 'cancer-awareness-ribbon'),
            ],
            [
                'type'        => 'textfield',
                'heading'     => __('Size (px)', 'cancer-awareness-ribbon'),
                'param_name'  => 'size',
                'value'       => '64',
                'description' => __('Number in pixels (16–512).', 'cancer-awareness-ribbon'),
            ],
            [
                'type'        => 'checkbox',
                'heading'     => __('Show Label', 'cancer-awareness-ribbon'),
                'param_name'  => 'label',
                'value'       => [__('Yes', 'cancer-awareness-ribbon') => '1'],
                'description' => __('Display the ribbon label under the icon.', 'cancer-awareness-ribbon'),
            ],
            [
                'type'        => 'dropdown',
                'heading'     => __('Category Filter', 'cancer-awareness-ribbon'),
                'param_name'  => 'category',
                'value'       => [
                    __('All', 'cancer-awareness-ribbon')    => '',
                    __('Cancer', 'cancer-awareness-ribbon') => 'Cancer',
                    __('Medical', 'cancer-awareness-ribbon') => 'Medical',
                    __('Social', 'cancer-awareness-ribbon') => 'Social',
                    __('Global', 'cancer-awareness-ribbon') => 'Global',
                ],
                'std'         => '',
                'description' => __('Optional filter (mainly affects list mode and auto selection).', 'cancer-awareness-ribbon'),
            ],
            [
                'type'        => 'checkbox',
                'heading'     => __('List Mode', 'cancer-awareness-ribbon'),
                'param_name'  => 'list',
                'value'       => [__('Yes', 'cancer-awareness-ribbon') => '1'],
                'description' => __('Show all ribbons for the selected month (and optional category).', 'cancer-awareness-ribbon'),
            ],
            [
                'type'        => 'textfield',
                'heading'     => __('Extra CSS Class', 'cancer-awareness-ribbon'),
                'param_name'  => 'class',
                'value'       => '',
                'description' => __('Adds a custom class to the wrapper.', 'cancer-awareness-ribbon'),
            ],
        ],
    ]);
}

add_action('vc_before_init', 'car_register_wpbakery_element');

<?php
if (!defined('ABSPATH')) exit;

/**
 * Beaver Builder Integration
 *
 * Registers a Beaver Builder module that renders the existing [cancer_ribbon] output.
 */

function car_beaver_is_active(): bool
{
    return class_exists('FLBuilder');
}

function car_register_beaver_module(): void
{
    if (!car_beaver_is_active()) return;

    $module_file = __DIR__ . '/class-car-beaver-ribbon-module.php';
    if (!file_exists($module_file)) return;

    require_once $module_file;

    // Register module + settings form
    if (class_exists('CAR_Beaver_Ribbon_Module')) {
        FLBuilder::register_module('CAR_Beaver_Ribbon_Module', [
            'general' => [
                'title'    => __('Ribbon', 'cancer-awareness-ribbon'),
                'sections' => [
                    'settings' => [
                        'title'  => __('Settings', 'cancer-awareness-ribbon'),
                        'fields' => [
                            'type' => [
                                'type'    => 'select',
                                'label'   => __('Ribbon Type', 'cancer-awareness-ribbon'),
                                'default' => '',
                                'options' => car_beaver_type_options(),
                            ],
                            'month' => [
                                'type'    => 'select',
                                'label'   => __('Month', 'cancer-awareness-ribbon'),
                                'default' => '',
                                'options' => [
                                    ''   => __('Auto (Current Month)', 'cancer-awareness-ribbon'),
                                    '1'  => __('January', 'cancer-awareness-ribbon'),
                                    '2'  => __('February', 'cancer-awareness-ribbon'),
                                    '3'  => __('March', 'cancer-awareness-ribbon'),
                                    '4'  => __('April', 'cancer-awareness-ribbon'),
                                    '5'  => __('May', 'cancer-awareness-ribbon'),
                                    '6'  => __('June', 'cancer-awareness-ribbon'),
                                    '7'  => __('July', 'cancer-awareness-ribbon'),
                                    '8'  => __('August', 'cancer-awareness-ribbon'),
                                    '9'  => __('September', 'cancer-awareness-ribbon'),
                                    '10' => __('October', 'cancer-awareness-ribbon'),
                                    '11' => __('November', 'cancer-awareness-ribbon'),
                                    '12' => __('December', 'cancer-awareness-ribbon'),
                                ],
                            ],
                            'size' => [
                                'type'        => 'unit',
                                'label'       => __('Size (px)', 'cancer-awareness-ribbon'),
                                'default'     => '64',
                                'units'       => ['px'],
                                'description' => __('16–512', 'cancer-awareness-ribbon'),
                                'slider'      => [
                                    'min'  => 16,
                                    'max'  => 512,
                                    'step' => 1,
                                ],
                            ],
                            'show_label' => [
                                'type'    => 'select',
                                'label'   => __('Show Label', 'cancer-awareness-ribbon'),
                                'default' => '0',
                                'options' => [
                                    '0' => __('No', 'cancer-awareness-ribbon'),
                                    '1' => __('Yes', 'cancer-awareness-ribbon'),
                                ],
                            ],
                            'category' => [
                                'type'    => 'select',
                                'label'   => __('Category Filter', 'cancer-awareness-ribbon'),
                                'default' => '',
                                'options' => [
                                    ''        => __('All', 'cancer-awareness-ribbon'),
                                    'Cancer'  => __('Cancer', 'cancer-awareness-ribbon'),
                                    'Medical' => __('Medical', 'cancer-awareness-ribbon'),
                                    'Social'  => __('Social', 'cancer-awareness-ribbon'),
                                    'Global'  => __('Global', 'cancer-awareness-ribbon'),
                                ],
                            ],
                            'list_mode' => [
                                'type'    => 'select',
                                'label'   => __('List Mode', 'cancer-awareness-ribbon'),
                                'default' => '0',
                                'options' => [
                                    '0' => __('Off', 'cancer-awareness-ribbon'),
                                    '1' => __('On (show all ribbons for month)', 'cancer-awareness-ribbon'),
                                ],
                            ],
                            'extra_class' => [
                                'type'        => 'text',
                                'label'       => __('Extra CSS Class', 'cancer-awareness-ribbon'),
                                'default'     => '',
                                'placeholder' => 'my-custom-class',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}

/**
 * Beaver expects options as [value => label]
 */
function car_beaver_type_options(): array
{
    $out = ['' => __('Auto (Featured / Month)', 'cancer-awareness-ribbon')];

    if (function_exists('car_get_awareness_types_select_options_flat')) {
        $flat = car_get_awareness_types_select_options_flat(); // value => label
        foreach ($flat as $value => $label) {
            $out[(string)$value] = (string)$label;
        }
    }

    return $out;
}

add_action('init', 'car_register_beaver_module', 30);

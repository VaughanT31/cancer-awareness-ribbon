<?php
if (!defined('ABSPATH')) exit;

/**
 * Divi Integration
 *
 * Registers a custom Divi Builder module that renders the existing [cancer_ribbon] output.
 */

function car_divi_is_active(): bool
{
    // Divi Builder defines this function
    return function_exists('et_builder_init') || class_exists('ET_Builder_Module');
}

function car_register_divi_module(): void
{
    if (!car_divi_is_active()) return;

    $module_file = __DIR__ . '/class-car-divi-ribbon-module.php';
    if (!file_exists($module_file)) return;

    require_once $module_file;

    if (class_exists('CAR_Divi_Ribbon_Module')) {
        new CAR_Divi_Ribbon_Module();
    }
}

add_action('et_builder_ready', 'car_register_divi_module', 20);

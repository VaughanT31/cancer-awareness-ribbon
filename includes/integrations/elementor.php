<?php
if (!defined('ABSPATH')) exit;

/**
 * Elementor Integration (v1.5+)
 */
function car_elementor_is_active(): bool
{
    return did_action('elementor/loaded') || defined('ELEMENTOR_VERSION');
}

function car_register_elementor_ribbon_widget(): void
{
    if (!car_elementor_is_active()) return;

    $widget_file = __DIR__ . '/class-car-elementor-ribbon-widget.php';
    if (!file_exists($widget_file)) return;

    require_once $widget_file;

    // Elementor 3.5+
    add_action('elementor/widgets/register', function ($widgets_manager) {
        if (class_exists('CAR_Elementor_Ribbon_Widget')) {
            $widgets_manager->register(new CAR_Elementor_Ribbon_Widget());
        }
    });

    // Backwards compatibility (older Elementor)
    add_action('elementor/widgets/widgets_registered', function () {
        if (!class_exists('\Elementor\Plugin')) return;
        if (!class_exists('CAR_Elementor_Ribbon_Widget')) return;

        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CAR_Elementor_Ribbon_Widget());
    });
}

add_action('init', 'car_register_elementor_ribbon_widget', 30);

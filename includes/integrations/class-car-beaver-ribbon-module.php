<?php
if (!defined('ABSPATH')) exit;

if (!class_exists('FLBuilderModule')) return;

class CAR_Beaver_Ribbon_Module extends FLBuilderModule
{
    public function __construct()
    {
        parent::__construct([
            'name'            => __('Awareness Ribbon', 'cancer-awareness-ribbon'),
            'description'     => __('Displays an awareness ribbon.', 'cancer-awareness-ribbon'),
            'category'        => __('Content', 'cancer-awareness-ribbon'),
            'dir'             => plugin_dir_path(__FILE__),
            'url'             => plugin_dir_url(__FILE__),
            'editor_export'   => true,
            'enabled'         => true,
            'partial_refresh' => true,
        ]);
    }

    public function render()
    {
        // This method is not used in all Beaver versions; frontend rendering will use frontend.php if present.
        echo $this->get_ribbon_html();
    }

    public function get_ribbon_html(): string
    {
        if (!function_exists('car_render_awareness_ribbon')) return '';

        $type = isset($this->settings->type) ? (string)$this->settings->type : '';
        $month = isset($this->settings->month) ? (string)$this->settings->month : '';
        $size = 64;

        // Beaver 'unit' stores like: {value: "64", unit:"px"} in some versions; sometimes plain string.
        if (isset($this->settings->size)) {
            if (is_object($this->settings->size) && isset($this->settings->size->value)) {
                $size = (int)$this->settings->size->value;
            } else {
                $size = (int)$this->settings->size;
            }
        }

        $atts = [
            'type'     => $type,
            'month'    => $month,
            'size'     => (string)car_clamp_int($size, 16, 512),
            'label'    => (!empty($this->settings->show_label) && (string)$this->settings->show_label === '1') ? '1' : '0',
            'category' => isset($this->settings->category) ? (string)$this->settings->category : '',
            'list'     => (!empty($this->settings->list_mode) && (string)$this->settings->list_mode === '1') ? '1' : '0',
            'class'    => isset($this->settings->extra_class) ? (string)$this->settings->extra_class : '',
        ];

        return car_render_awareness_ribbon($atts);
    }
}

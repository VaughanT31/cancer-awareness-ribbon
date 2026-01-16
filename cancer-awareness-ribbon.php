<?php

/**
 * Plugin Name: Cancer Awareness Ribbon Shortcode
 * Description: Adds a shortcode to display a cancer awareness ribbon whose colors change based on the current month (or by type override).
 * Version: 1.0.1
 * Author: Parallel Media
 * License: GPLv2 or later
 */

if (!defined('ABSPATH')) exit;

/**
 * Cancer list: type => [label, month, colors[]]
 */
function car_get_cancers(): array
{
    return [
        'appendix_cancer' => ['label' => 'Appendix Cancer', 'month' => 8, 'colors' => ['#FFBF00']], // Amber
        'bladder_cancer' => ['label' => 'Bladder Cancer', 'month' => 5, 'colors' => ['#FFD400', '#6A0DAD', '#001F3F']], // Yellow, purple, navy
        'blood_cancer' => ['label' => 'Blood Cancer', 'month' => 9, 'colors' => ['#D0021B']], // Red
        'leukemia' => ['label' => 'Leukemia', 'month' => 9, 'colors' => ['#F57C00']], // Orange
        'hodgkin_lymphoma' => ['label' => 'Hodgkin Lymphoma', 'month' => 9, 'colors' => ['#8F00FF']], // Violet
        'non_hodgkin_lymphoma' => ['label' => 'Non-Hodgkin Lymphoma', 'month' => 9, 'colors' => ['#32CD32']], // Lime green
        'myeloma' => ['label' => 'Myeloma', 'month' => 3, 'colors' => ['#800020']], // Burgundy
        'bone_cancer' => ['label' => 'Bone Cancer', 'month' => 7, 'colors' => ['#FFD400']], // Yellow
        'brain_cancer' => ['label' => 'Brain Cancer', 'month' => 5, 'colors' => ['#808080']], // Gray
        'breast_cancer' => ['label' => 'Breast Cancer', 'month' => 10, 'colors' => ['#FF69B4']], // Pink
        'metastatic_breast_cancer' => ['label' => 'Metastatic Breast Cancer', 'month' => 10, 'colors' => ['#FF69B4', '#00B3B3', '#2ECC71']], // Pink, teal, green
        'inflammatory_breast_cancer' => ['label' => 'Inflammatory Breast Cancer', 'month' => 10, 'colors' => ['#FF1493']], // Hot pink
        'male_breast_cancer' => ['label' => 'Male Breast Cancer', 'month' => 10, 'colors' => ['#FF69B4', '#1E90FF']], // Pink and blue
        'childhood_cancer' => ['label' => 'Childhood Cancer', 'month' => 9, 'colors' => ['#D4AF37']], // Gold
        'colorectal_cancer' => ['label' => 'Colorectal Cancer', 'month' => 3, 'colors' => ['#003399']], // Dark blue
        'gallbladder_bile_duct_cancer' => ['label' => 'Gallbladder & Bile Duct Cancer', 'month' => 2, 'colors' => ['#4CBB17']], // Kelly green
        'gastric_cancer' => ['label' => 'Gastric Cancer', 'month' => 11, 'colors' => ['#CCCCFF']], // Periwinkle
        'gynecological_cancer' => ['label' => 'Gynecological Cancer', 'month' => 9, 'colors' => ['#800080']], // Purple
        'cervical_cancer' => ['label' => 'Cervical Cancer', 'month' => 1, 'colors' => ['#00B3B3', '#FFFFFF']], // Teal and white
        'ovarian_cancer' => ['label' => 'Ovarian Cancer', 'month' => 9, 'colors' => ['#00B3B3']], // Teal
        'uterine_cancer' => ['label' => 'Uterine Cancer', 'month' => 9, 'colors' => ['#FFC0CB']], // Peach (approx)
        'vaginal_vulvar_cancers' => ['label' => 'Vaginal and Vulvar Cancers', 'month' => 9, 'colors' => ['#800080']], // Purple
        'head_neck_cancer' => ['label' => 'Head & Neck Cancer', 'month' => 4, 'colors' => ['#800020', '#FFFFFF']], // Burgundy and white
        'kidney_cancer' => ['label' => 'Kidney Cancer', 'month' => 3, 'colors' => ['#F57C00']], // Orange
        'liver_cancer' => ['label' => 'Liver Cancer', 'month' => 10, 'colors' => ['#2ECC71']], // Green
        'lung_cancer' => ['label' => 'Lung Cancer', 'month' => 11, 'colors' => ['#FFFFFF']], // Pearl/white
        'pancreatic_cancer' => ['label' => 'Pancreatic Cancer', 'month' => 11, 'colors' => ['#800080']], // Purple
        'prostate_cancer' => ['label' => 'Prostate Cancer', 'month' => 9, 'colors' => ['#7EC8E3']], // Light blue
        'skin_cancer' => ['label' => 'Skin Cancer', 'month' => 5, 'colors' => ['#111111']], // Black
        'testicular_cancer' => ['label' => 'Testicular Cancer', 'month' => 4, 'colors' => ['#800080']], // Purple
        'thyroid_cancer' => ['label' => 'Thyroid Cancer', 'month' => 9, 'colors' => ['#800080', '#00B3B3', '#FF69B4']], // Purple, teal, pink
    ];
}

/**
 * Featured selection when multiple cancers share a month (your chosen defaults).
 */
function car_featured_by_month(): array
{
    return [
        1  => 'cervical_cancer',
        2  => 'gallbladder_bile_duct_cancer',
        3  => 'colorectal_cancer',
        4  => 'head_neck_cancer',
        5  => 'bladder_cancer',
        6  => 'breast_cancer', // fallback month
        7  => 'bone_cancer',
        8  => 'appendix_cancer',
        9  => 'blood_cancer',
        10 => 'breast_cancer',
        11 => 'gastric_cancer',
        12 => 'breast_cancer', // fallback month
    ];
}

function car_clamp_int($v, int $min, int $max): int
{
    $v = (int)$v;
    return max($min, min($max, $v));
}

/**
 * Print CSS once (header-safe).
 */
function car_enqueue_inline_css_once(): void
{
    static $done = false;
    if ($done) return;
    $done = true;

    add_action('wp_head', function () {
        echo '<style>
.car-ribbon-wrap{display:inline-flex;align-items:center;gap:10px;line-height:1}
.car-ribbon{width:var(--car-size,64px);height:var(--car-size,64px);display:block;border: 1px solid #3a3a3a;border-radius: 15px;
    box-shadow: 0 0 15px #080808;}
.car-ribbon-label{font-size:14px;font-weight:600;opacity:.9}
</style>';
    }, 50);
}

function car_render_ribbon_svg(array $colors, int $size, string $label): string
{
    $colors = array_values(array_filter(array_map('trim', $colors)));
    if (!$colors) $colors = ['#999999'];

    $uid = 'car_' . wp_generate_uuid4();
    $grad_id = $uid . '_grad';

    // Build gradient stops
    $stops = '';
    $count = count($colors);
    if ($count === 1) {
        $stops .= '<stop offset="0%" stop-color="' . esc_attr($colors[0]) . '"/>';
        $stops .= '<stop offset="100%" stop-color="' . esc_attr($colors[0]) . '"/>';
    } else {
        for ($i = 0; $i < $count; $i++) {
            $offset = ($i / ($count - 1)) * 100;
            $stops .= '<stop offset="' . esc_attr(round($offset, 2)) . '%" stop-color="' . esc_attr($colors[$i]) . '"/>';
        }
    }

    $ribbon_path_d = 'M1442.292,635.676c14.922,30.926,21.659,65.385,19.481,99.653
c-2.178,34.269-13.222,67.596-31.94,96.381l-155.582,239.338l-167.239-217.519l198.792-258.572
c4.582-5.962,8.825-12.164,12.726-18.565c0.19-0.261,0.354-0.536,0.494-0.821c19.813-32.84,30.55-70.913,30.55-109.4
c0-8.703-0.551-17.419-1.637-26.073L1442.292,635.676z M881.421,379.246c13.848-28.709,37.995-53.058,69.83-70.412
c39.172-21.355,89.218-32.183,148.749-32.183s109.576,10.828,148.749,32.183c31.835,17.354,55.981,41.703,69.83,70.412l0.02,0.04
c12.991,26.936,19.857,56.979,19.857,86.884c0,34.05-8.868,67.76-25.327,97.408c-7.825-8.528-24.321-24.743-49.703-41.068
c-33.208-21.358-88.518-46.819-163.426-46.819s-130.217,25.46-163.426,46.819c-25.382,16.325-41.878,32.54-49.703,41.068
c-16.459-29.648-25.327-63.358-25.327-97.408C861.545,436.251,868.418,406.194,881.421,379.246z M826.783,1759.396
l-157.379-336.675l255.586-332.444l168.38,259.026L826.783,1759.396z M1373.217,1759.396l-268.557-413.123l-0.042-0.064
c-0.007-0.01-0.013-0.02-0.02-0.03L770.167,831.709c-18.718-28.784-29.762-62.112-31.94-96.38s4.559-68.728,19.482-99.653
l94.354-195.578c-1.086,8.654-1.637,17.37-1.637,26.073c0,38.495,10.741,76.575,30.562,109.42c0.135,0.271,0.29,0.533,0.47,0.782
c3.905,6.407,8.15,12.616,12.737,18.584l201.396,261.96l174.631,227.134l260.372,338.67L1373.217,1759.396z';

    return '
<svg class="car-ribbon" width="' . esc_attr($size) . '" height="' . esc_attr($size) . '"
     viewBox="0 0 2200 2200" preserveAspectRatio="xMidYMid meet"
     xmlns="http://www.w3.org/2000/svg" role="img"
     aria-label="' . esc_attr($label) . ' Awareness Ribbon">
  <defs>
    <linearGradient id="' . esc_attr($grad_id) . '" x1="0%" y1="0%" x2="100%" y2="100%">
      ' . $stops . '
    </linearGradient>
  </defs>

  <path d="' . esc_attr($ribbon_path_d) . '" fill="url(#' . esc_attr($grad_id) . ')" />
</svg>';
}

/**
 * The [cancer_ribbon] shortcode.
 *
 * Attributes:
 * - type: a key like "breast_cancer"
 * - month: 1-12 (override)
 * - size: px (default 64)
 * - label: 1/0 (show text label)
 * - class: extra wrapper class
 */
function car_shortcode_cancer_ribbon($atts): string
{
    $atts = shortcode_atts([
        'type'  => '',
        'month' => '',
        'size'  => '64',
        'label' => '0',
        'class' => '',
    ], $atts, 'cancer_ribbon');

    $cancers = car_get_cancers();

    $size = car_clamp_int($atts['size'], 16, 512);
    $show_label = ($atts['label'] === '1' || strtolower((string)$atts['label']) === 'true');

    // Month (WP timezone)
    if ($atts['month'] !== '') {
        $month = car_clamp_int($atts['month'], 1, 12);
    } else {
        $dt = new DateTime('now', wp_timezone());
        $month = (int)$dt->format('n');
    }

    $type = sanitize_key((string)$atts['type']);
    $selected = null;

    if ($type && isset($cancers[$type])) {
        $selected = $cancers[$type];
    } else {
        $featured = car_featured_by_month();
        if (isset($featured[$month]) && isset($cancers[$featured[$month]])) {
            $selected = $cancers[$featured[$month]];
        } else {
            foreach ($cancers as $item) {
                if ((int)$item['month'] === (int)$month) {
                    $selected = $item;
                    break;
                }
            }
        }

        if (!$selected) {
            $selected = ['label' => 'Cancer Awareness', 'month' => $month, 'colors' => ['#999999']];
        }
    }

    car_enqueue_inline_css_once();

    $extra_class = sanitize_html_class((string)$atts['class']);
    $wrap_class = 'car-ribbon-wrap' . ($extra_class ? ' ' . $extra_class : '');

    $svg = car_render_ribbon_svg($selected['colors'], $size, $selected['label']);

    $html  = '<div class="' . esc_attr($wrap_class) . '" style="--car-size:' . esc_attr($size) . 'px;height:64px">';
    $html .= $svg;
    if ($show_label) {
        $html .= '<div class="car-ribbon-label">' . esc_html($selected['label']) . '</div>';
    }
    $html .= '</div>';

    return $html;
}

/**
 * Register shortcode on init (safe timing).
 */
add_action('init', function () {
    add_shortcode('cancer_ribbon', 'car_shortcode_cancer_ribbon');
});

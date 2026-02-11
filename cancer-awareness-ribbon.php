<?php

/**
 * Plugin Name: Cancer Awareness Ribbon Shortcode
 * Plugin URI: https://www.parallelmedia.co.za/cancer-awareness-ribbon-demo/
 * Description: Adds a shortcode to display an awareness ribbon whose colors change based on the current month (or by type override).
 * Version: 1.5.1
 * Author: Parallel Media
 * Author URI: https://parallelmedia.co.za
 * License: GPLv2 or later
 */

if (!defined('ABSPATH')) exit;

/**
 * Register stylesheet (do not enqueue globally).
 */
add_action('wp_enqueue_scripts', function () {
    wp_register_style(
        'car-ribbon-style',
        plugins_url('assets/css/cancer-awareness-ribbon.css', __FILE__),
        [],
        '1.5.0'
    );
}, 20);

/**
 * Default awareness types list (internal).
 * Schema: type => [label, month, colors[], optional category]
 * Categories: Cancer, Medical, Social, Global
 */
function car_get_default_awareness_types(): array
{
    return [
        'appendix_cancer' => ['label' => 'Appendix Cancer', 'month' => 8, 'colors' => ['#FFBF00']],
        'bladder_cancer' => ['label' => 'Bladder Cancer', 'month' => 5, 'colors' => ['#FFD400', '#6A0DAD', '#001F3F']],
        'blood_cancer' => ['label' => 'Blood Cancer', 'month' => 9, 'colors' => ['#D0021B']],
        'leukemia' => ['label' => 'Leukemia', 'month' => 9, 'colors' => ['#F57C00']],
        'hodgkin_lymphoma' => ['label' => 'Hodgkin Lymphoma', 'month' => 9, 'colors' => ['#8F00FF']],
        'non_hodgkin_lymphoma' => ['label' => 'Non-Hodgkin Lymphoma', 'month' => 9, 'colors' => ['#32CD32']],
        'myeloma' => ['label' => 'Myeloma', 'month' => 3, 'colors' => ['#800020']],
        'bone_cancer' => ['label' => 'Bone Cancer', 'month' => 7, 'colors' => ['#FFD400']],
        'brain_cancer' => ['label' => 'Brain Cancer', 'month' => 5, 'colors' => ['#808080']],
        'breast_cancer' => ['label' => 'Breast Cancer', 'month' => 10, 'colors' => ['#FF69B4']],
        'metastatic_breast_cancer' => ['label' => 'Metastatic Breast Cancer', 'month' => 10, 'colors' => ['#FF69B4', '#00B3B3', '#2ECC71']],
        'inflammatory_breast_cancer' => ['label' => 'Inflammatory Breast Cancer', 'month' => 10, 'colors' => ['#FF1493']],
        'male_breast_cancer' => ['label' => 'Male Breast Cancer', 'month' => 10, 'colors' => ['#FF69B4', '#1E90FF']],
        'childhood_cancer' => ['label' => 'Childhood Cancer', 'month' => 9, 'colors' => ['#D4AF37']],
        'colorectal_cancer' => ['label' => 'Colorectal Cancer', 'month' => 3, 'colors' => ['#003399']],
        'gallbladder_bile_duct_cancer' => ['label' => 'Gallbladder & Bile Duct Cancer', 'month' => 2, 'colors' => ['#4CBB17']],
        'gastric_cancer' => ['label' => 'Gastric Cancer', 'month' => 11, 'colors' => ['#CCCCFF']],
        'gynecological_cancer' => ['label' => 'Gynecological Cancer', 'month' => 9, 'colors' => ['#800080']],
        'cervical_cancer' => ['label' => 'Cervical Cancer', 'month' => 1, 'colors' => ['#00B3B3', '#FFFFFF']],
        'ovarian_cancer' => ['label' => 'Ovarian Cancer', 'month' => 9, 'colors' => ['#00B3B3']],
        'uterine_cancer' => ['label' => 'Uterine Cancer', 'month' => 9, 'colors' => ['#FFC0CB']],
        'vaginal_vulvar_cancers' => ['label' => 'Vaginal and Vulvar Cancers', 'month' => 9, 'colors' => ['#800080']],
        'head_neck_cancer' => ['label' => 'Head & Neck Cancer', 'month' => 4, 'colors' => ['#800020', '#FFFFFF']],
        'kidney_cancer' => ['label' => 'Kidney Cancer', 'month' => 3, 'colors' => ['#F57C00']],
        'liver_cancer' => ['label' => 'Liver Cancer', 'month' => 10, 'colors' => ['#2ECC71']],
        'lung_cancer' => ['label' => 'Lung Cancer', 'month' => 11, 'colors' => ['#FFFFFF']],
        'pancreatic_cancer' => ['label' => 'Pancreatic Cancer', 'month' => 11, 'colors' => ['#800080']],
        'prostate_cancer' => ['label' => 'Prostate Cancer', 'month' => 9, 'colors' => ['#7EC8E3']],
        'skin_cancer' => ['label' => 'Skin Cancer', 'month' => 5, 'colors' => ['#111111']],
        'testicular_cancer' => ['label' => 'Testicular Cancer', 'month' => 4, 'colors' => ['#800080']],
        'thyroid_cancer' => ['label' => 'Thyroid Cancer', 'month' => 9, 'colors' => ['#800080', '#00B3B3', '#FF69B4']],

        // additional awareness ribbons (non-cancer)
        'hiv_aids_awareness' => ['label' => 'HIV / AIDS Awareness', 'month' => 12, 'colors' => ['#E10600'], 'category' => 'Global'],
        'autism_awareness' => ['label' => 'Autism Awareness', 'month' => 4, 'colors' => ['#1877F2'], 'category' => 'Medical'],
        'mental_health_awareness' => ['label' => 'Mental Health Awareness', 'month' => 5, 'colors' => ['#2E7D32'], 'category' => 'Medical'],
        'diabetes_awareness' => ['label' => 'Diabetes Awareness', 'month' => 11, 'colors' => ['#9E9E9E'], 'category' => 'Medical'],
        'heart_disease_awareness' => ['label' => 'Heart Disease Awareness', 'month' => 2, 'colors' => ['#C62828'], 'category' => 'Medical'],
        'domestic_violence_awareness' => ['label' => 'Domestic Violence Awareness', 'month' => 10, 'colors' => ['#800080'], 'category' => 'Social'],
        'prostate_health_awareness' => ['label' => 'Prostate Health Awareness', 'month' => 9, 'colors' => ['#7EC8E3'], 'category' => 'Medical'],
        'ovarian_health_awareness' => ['label' => 'Ovarian Health Awareness', 'month' => 9, 'colors' => ['#00B3B3'], 'category' => 'Medical'],
        'lung_health_awareness' => ['label' => 'Lung Health Awareness', 'month' => 11, 'colors' => ['#FFFFFF'], 'category' => 'Medical'],
        'alzheimers_awareness' => ['label' => 'Alzheimer’s Awareness', 'month' => 11, 'colors' => ['#5E2D79'], 'category' => 'Medical'],
        'pride_awareness' => ['label' => 'Pride Awareness', 'month' => 6, 'colors' => ['#E40303', '#FF8C00', '#FFED00', '#008026', '#004DFF', '#750787'], 'category' => 'Social'],
        'veterans_awareness' => ['label' => 'Veterans Awareness', 'month' => 11, 'colors' => ['#B22234', '#FFFFFF', '#3C3B6E'], 'category' => 'Social'],
        'child_protection_awareness' => ['label' => 'Child Protection Awareness', 'month' => 4, 'colors' => ['#0057B8'], 'category' => 'Social'],
        'anti_bullying_awareness' => ['label' => 'Anti-Bullying Awareness', 'month' => 10, 'colors' => ['#1E90FF'], 'category' => 'Social'],
        'organ_donation_awareness' => ['label' => 'Organ Donation Awareness', 'month' => 4, 'colors' => ['#4CAF50'], 'category' => 'Medical'],
    ];
}

/**
 * Basic hex color validator (#RGB or #RRGGBB).
 */
function car_is_hex_color($c): bool
{
    $c = trim((string)$c);
    if ($c === '') return false;
    return (bool)preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $c);
}

function car_clamp_int($v, int $min, int $max): int
{
    $v = (int)$v;
    return max($min, min($max, $v));
}

function car_normalize_category($v): string
{
    $v = trim((string)$v);
    if ($v === '') return '';
    $v = strtolower($v);

    if ($v === 'cancers') $v = 'cancer';
    if ($v === 'med') $v = 'medical';

    $map = [
        'cancer'  => 'Cancer',
        'medical' => 'Medical',
        'social'  => 'Social',
        'global'  => 'Global',
    ];

    return $map[$v] ?? '';
}

function car_sanitize_awareness_types($types): array
{
    if (!is_array($types)) return [];

    $out = [];
    foreach ($types as $raw_key => $raw_item) {
        $key = sanitize_key((string)$raw_key);
        if ($key === '') continue;
        if (!is_array($raw_item)) continue;

        $label = isset($raw_item['label']) ? trim((string)$raw_item['label']) : '';
        if ($label === '') continue;

        $month = isset($raw_item['month']) ? (int)$raw_item['month'] : 0;
        if ($month !== 0) $month = car_clamp_int($month, 1, 12);

        $colors_in = $raw_item['colors'] ?? [];
        if (!is_array($colors_in)) $colors_in = [$colors_in];

        $colors = [];
        foreach ($colors_in as $c) {
            $c = trim((string)$c);
            if ($c === '') continue;
            if (!car_is_hex_color($c)) continue;
            $colors[] = $c;
        }
        if (!$colors) $colors = ['#999999'];

        $category = '';
        if (isset($raw_item['category'])) {
            $category = car_normalize_category($raw_item['category']);
        }

        $item = [
            'label'  => $label,
            'month'  => $month,
            'colors' => $colors,
        ];
        if ($category !== '') $item['category'] = $category;

        $out[$key] = $item;
    }

    return $out;
}

/**
 * Awareness Types Registry (v1.5)
 *
 * Developers can register/modify awareness ribbons via:
 *   add_filter('car_awareness_types', function(array $types) { ...; return $types; });
 */
function car_get_awareness_types(): array
{
    $types = car_get_default_awareness_types();
    $types = apply_filters('car_awareness_types', $types);
    return car_sanitize_awareness_types($types);
}

/**
 * Backwards compatibility wrapper (deprecated).
 *
 * @deprecated 1.5.0 Use car_get_awareness_types()
 */
function car_get_cancers(): array
{
    return car_get_awareness_types();
}

function car_item_category(array $item): string
{
    $cat = isset($item['category']) ? car_normalize_category($item['category']) : '';
    return $cat !== '' ? $cat : 'Cancer';
}

function car_group_items_by_category(array $items): array
{
    $order = ['Cancer', 'Medical', 'Social', 'Global'];
    $grouped = [
        'Cancer' => [],
        'Medical' => [],
        'Social' => [],
        'Global' => [],
    ];

    foreach ($items as $key => $item) {
        $cat = car_item_category($item);
        if (!isset($grouped[$cat])) $grouped[$cat] = [];
        $grouped[$cat][$key] = $item;
    }

    $out = [];
    foreach ($order as $cat) {
        if (!empty($grouped[$cat])) $out[$cat] = $grouped[$cat];
        unset($grouped[$cat]);
    }
    foreach ($grouped as $cat => $bucket) {
        if (!empty($bucket)) $out[$cat] = $bucket;
    }

    return $out;
}

/**
 * Helper for builder select options (flat).
 * Elementor SELECT does not reliably support optgroups (nested arrays).
 */
function car_get_awareness_types_select_options_flat(): array
{
    $types = car_get_awareness_types();
    $out = [];

    foreach ($types as $key => $item) {
        $label = (string)($item['label'] ?? $key);
        $cat = car_item_category($item);
        $out[$key] = $cat . ' | ' . $label;
    }

    // Optional: sort by label (keeps it tidy)
    asort($out, SORT_NATURAL | SORT_FLAG_CASE);

    return $out;
}

function car_featured_by_month(): array
{
    return [
        1  => 'cervical_cancer',
        2  => 'gallbladder_bile_duct_cancer',
        3  => 'colorectal_cancer',
        4  => 'head_neck_cancer',
        5  => 'bladder_cancer',
        6  => 'breast_cancer',
        7  => 'bone_cancer',
        8  => 'appendix_cancer',
        9  => 'blood_cancer',
        10 => 'breast_cancer',
        11 => 'gastric_cancer',
        12 => 'breast_cancer',
    ];
}

function car_render_ribbon_svg(array $colors, int $size, string $label): string
{
    $colors = array_values(array_filter(array_map('trim', $colors)));
    if (!$colors) $colors = ['#999999'];

    $uid = 'car_' . wp_generate_uuid4();
    $grad_id = $uid . '_grad';

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
l-157.379-336.675l255.586-332.444l168.38,259.026L826.783,1759.396z M1373.217,1759.396
l-268.557-413.123l-0.042-0.064
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
 * Shared renderer so shortcode + builders can call the same logic.
 */
function car_render_awareness_ribbon(array $atts = []): string
{
    return car_shortcode_cancer_ribbon($atts);
}

function car_shortcode_cancer_ribbon($atts): string
{
    $atts = shortcode_atts([
        'type'     => '',
        'month'    => '',
        'size'     => '64',
        'label'    => '0',
        'class'    => '',
        'category' => '',
        'list'     => '0',
    ], $atts, 'cancer_ribbon');

    wp_enqueue_style('car-ribbon-style');

    $types = car_get_awareness_types();

    $size = car_clamp_int($atts['size'], 16, 512);
    $show_label = ($atts['label'] === '1' || strtolower((string)$atts['label']) === 'true');

    if ($atts['month'] !== '') {
        $month = car_clamp_int($atts['month'], 1, 12);
    } else {
        $dt = new DateTime('now', wp_timezone());
        $month = (int)$dt->format('n');
    }

    $category = car_normalize_category($atts['category']);
    $list_mode = ($atts['list'] === '1' || strtolower((string)$atts['list']) === 'true');

    $extra_class = sanitize_html_class((string)$atts['class']);

    if ($list_mode) {
        $matches = [];

        foreach ($types as $key => $item) {
            if ((int)($item['month'] ?? 0) !== (int)$month) continue;

            $item_cat = car_item_category($item);
            if ($category !== '' && strcasecmp($item_cat, $category) !== 0) continue;

            $matches[$key] = $item;
        }

        if (!$matches) {
            $wrap_class = 'car-ribbon-list-wrap' . ($extra_class ? ' ' . $extra_class : '');
            return '<div class="' . esc_attr($wrap_class) . '"><div class="car-ribbon-empty">No awareness ribbons found.</div></div>';
        }

        $grouped = car_group_items_by_category($matches);

        $wrap_class = 'car-ribbon-list-wrap' . ($extra_class ? ' ' . $extra_class : '');
        $html = '<div class="' . esc_attr($wrap_class) . '">';

        foreach ($grouped as $cat => $bucket) {
            $html .= '<div class="car-ribbon-category">';
            $html .= '<div class="car-ribbon-category-title">' . esc_html($cat) . '</div>';
            $html .= '<div class="car-ribbon-category-grid" style="display:flex;flex-wrap:wrap;gap:14px;">';

            foreach ($bucket as $it) {
                $svg = car_render_ribbon_svg((array)$it['colors'], $size, (string)$it['label']);

                $html .= '<div class="car-ribbon-wrap" style="--car-size:' . esc_attr($size) . 'px;">';
                $html .= $svg;

                if ($show_label) {
                    $html .= '<div class="car-ribbon-label">' . esc_html((string)$it['label']) . '</div>';
                }

                $html .= '</div>';
            }

            $html .= '</div></div>';
        }

        $html .= '</div>';
        return $html;
    }

    $type = sanitize_key((string)$atts['type']);
    $selected = null;

    if ($type && isset($types[$type])) {
        $selected = $types[$type];
    } else {
        if ($category !== '' && $category !== 'Cancer') {
            foreach ($types as $item) {
                if ((int)($item['month'] ?? 0) === (int)$month && strcasecmp(car_item_category($item), $category) === 0) {
                    $selected = $item;
                    break;
                }
            }
        } else {
            $featured = car_featured_by_month();
            if (isset($featured[$month]) && isset($types[$featured[$month]])) {
                $candidate = $types[$featured[$month]];
                if ($category === '' || strcasecmp(car_item_category($candidate), $category) === 0) {
                    $selected = $candidate;
                }
            }
        }

        if (!$selected) {
            foreach ($types as $item) {
                if ((int)($item['month'] ?? 0) !== (int)$month) continue;
                if ($category !== '' && strcasecmp(car_item_category($item), $category) !== 0) continue;
                $selected = $item;
                break;
            }
        }

        if (!$selected) {
            $fallback_label = ($category !== '') ? ($category . ' Awareness') : 'Cancer Awareness';
            $selected = ['label' => $fallback_label, 'month' => $month, 'colors' => ['#999999']];
        }
    }

    $wrap_class = 'car-ribbon-wrap' . ($extra_class ? ' ' . $extra_class : '');
    $svg = car_render_ribbon_svg((array)$selected['colors'], $size, (string)$selected['label']);

    $html  = '<div class="' . esc_attr($wrap_class) . '" style="--car-size:' . esc_attr($size) . 'px;">';
    $html .= $svg;

    if ($show_label) {
        $html .= '<div class="car-ribbon-label">' . esc_html((string)$selected['label']) . '</div>';
    }

    $html .= '</div>';
    return $html;
}

add_action('init', function () {
    add_shortcode('cancer_ribbon', 'car_shortcode_cancer_ribbon');
});

/**
 * Integrations loader
 */
function car_load_integrations(): void
{
    // Admin page
    if (is_admin()) {
        $admin_loader = __DIR__ . '/includes/admin/admin.php';
        if (file_exists($admin_loader)) {
            require_once $admin_loader;
        }
    }

    // Elementor integration
    $elementor_loader = __DIR__ . '/includes/integrations/elementor.php';
    if (file_exists($elementor_loader)) {
        require_once $elementor_loader;
    }

    // WPBakery / Visual Composer integration
    $wpbakery_loader = __DIR__ . '/includes/integrations/wpbakery.php';
    if (file_exists($wpbakery_loader)) {
        require_once $wpbakery_loader;
    }

    // Divi integration
    $divi_loader = __DIR__ . '/includes/integrations/divi.php';
    if (file_exists($divi_loader)) {
        require_once $divi_loader;
    }

    // Beaver Builder integration
    $beaver_loader = __DIR__ . '/includes/integrations/beaver.php';
    if (file_exists($beaver_loader)) {
        require_once $beaver_loader;
    }
}
add_action('plugins_loaded', 'car_load_integrations', 30);


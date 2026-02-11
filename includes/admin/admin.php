<?php
if (!defined('ABSPATH')) exit;

function car_admin_menu(): void
{
    add_menu_page(
        __('Awareness Ribbon', 'cancer-awareness-ribbon'),
        __('Awareness Ribbon', 'cancer-awareness-ribbon'),
        'manage_options',
        'car-awareness-ribbon',
        'car_admin_page',
        'dashicons-heart',
        58
    );
}
add_action('admin_menu', 'car_admin_menu');

function car_admin_enqueue($hook): void
{
    if ($hook !== 'toplevel_page_car-awareness-ribbon') return;

    wp_enqueue_style(
        'car-admin-style',
        plugins_url('assets/css/admin.css', dirname(__DIR__, 2) . '/cancer-awareness-ribbon.php'),
        [],
        '1.5.0'
    );

    wp_enqueue_script(
        'car-admin-script',
        plugins_url('assets/js/admin.js', dirname(__DIR__, 2) . '/cancer-awareness-ribbon.php'),
        ['jquery'],
        '1.5.0',
        true
    );

    wp_localize_script('car-admin-script', 'CAR_ADMIN', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('car_admin_nonce'),
    ]);
}
add_action('admin_enqueue_scripts', 'car_admin_enqueue');

function car_get_settings_defaults(): array
{
    return [
        'type'     => '',
        'month'    => '',
        'size'     => 64,
        'label'    => 0,
        'class'    => '',
        'category' => '',
        'list'     => 0,
    ];
}

function car_get_settings(): array
{
    $saved = get_option('car_settings', []);
    if (!is_array($saved)) $saved = [];
    return array_merge(car_get_settings_defaults(), $saved);
}

function car_save_settings(array $incoming): array
{
    $defaults = car_get_settings_defaults();

    $out = [];
    $out['type']     = isset($incoming['type']) ? sanitize_key((string)$incoming['type']) : $defaults['type'];
    $out['month']    = isset($incoming['month']) ? (string)car_clamp_int($incoming['month'], 1, 12) : '';
    if ((string)($incoming['month'] ?? '') === '') $out['month'] = '';

    $size = isset($incoming['size']) ? (int)$incoming['size'] : (int)$defaults['size'];
    $out['size'] = car_clamp_int($size, 16, 512);

    $out['label']    = !empty($incoming['label']) ? 1 : 0;
    $out['list']     = !empty($incoming['list']) ? 1 : 0;
    $out['class']    = isset($incoming['class']) ? sanitize_html_class((string)$incoming['class']) : '';
    $out['category'] = isset($incoming['category']) ? car_normalize_category($incoming['category']) : '';

    update_option('car_settings', $out, false);
    return $out;
}

function car_admin_page(): void
{
    if (!current_user_can('manage_options')) return;

    $saved_notice = false;

    if (isset($_POST['car_save_settings'])) {
        check_admin_referer('car_admin_save_settings');
        car_save_settings($_POST);
        $saved_notice = true;
    }

    $settings = car_get_settings();
    $types = function_exists('car_get_awareness_types_select_options_flat')
        ? car_get_awareness_types_select_options_flat()
        : [];

    ?>
    <div class="wrap">
        <h1><?php echo esc_html__('Awareness Ribbon', 'cancer-awareness-ribbon'); ?></h1>

        <?php if ($saved_notice): ?>
            <div class="notice notice-success is-dismissible">
                <p><?php echo esc_html__('Settings saved.', 'cancer-awareness-ribbon'); ?></p>
            </div>
        <?php endif; ?>

        <div class="car-admin-grid">
            <div class="car-admin-card">
                <h2><?php echo esc_html__('Shortcode Builder', 'cancer-awareness-ribbon'); ?></h2>

                <form method="post">
                    <?php wp_nonce_field('car_admin_save_settings'); ?>

                    <table class="form-table" role="presentation">
                        <tbody>
                        <tr>
                            <th scope="row"><label for="car_type"><?php echo esc_html__('Ribbon Type', 'cancer-awareness-ribbon'); ?></label></th>
                            <td>
                                <select id="car_type" name="type" class="car-field">
                                    <option value=""><?php echo esc_html__('Auto (Featured / Month)', 'cancer-awareness-ribbon'); ?></option>
                                    <?php foreach ($types as $key => $label): ?>
                                        <option value="<?php echo esc_attr($key); ?>" <?php selected($settings['type'], $key); ?>>
                                            <?php echo esc_html($label); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <p class="description"><?php echo esc_html__('Choose a specific ribbon or leave on Auto.', 'cancer-awareness-ribbon'); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="car_month"><?php echo esc_html__('Month', 'cancer-awareness-ribbon'); ?></label></th>
                            <td>
                                <select id="car_month" name="month" class="car-field">
                                    <option value=""><?php echo esc_html__('Auto (Current Month)', 'cancer-awareness-ribbon'); ?></option>
                                    <?php
                                    $months = [
                                        1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',
                                        7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December'
                                    ];
                                    foreach ($months as $m => $name): ?>
                                        <option value="<?php echo esc_attr((string)$m); ?>" <?php selected((string)$settings['month'], (string)$m); ?>>
                                            <?php echo esc_html__($name, 'cancer-awareness-ribbon'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="car_size"><?php echo esc_html__('Size (px)', 'cancer-awareness-ribbon'); ?></label></th>
                            <td>
                                <input id="car_size" name="size" type="number" min="16" max="512" value="<?php echo esc_attr((string)$settings['size']); ?>" class="small-text car-field" />
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><?php echo esc_html__('Show Label', 'cancer-awareness-ribbon'); ?></th>
                            <td>
                                <label>
                                    <input type="checkbox" name="label" value="1" class="car-field" <?php checked((int)$settings['label'], 1); ?> />
                                    <?php echo esc_html__('Yes', 'cancer-awareness-ribbon'); ?>
                                </label>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="car_category"><?php echo esc_html__('Category Filter', 'cancer-awareness-ribbon'); ?></label></th>
                            <td>
                                <select id="car_category" name="category" class="car-field">
                                    <option value=""><?php echo esc_html__('All', 'cancer-awareness-ribbon'); ?></option>
                                    <option value="Cancer" <?php selected($settings['category'], 'Cancer'); ?>>Cancer</option>
                                    <option value="Medical" <?php selected($settings['category'], 'Medical'); ?>>Medical</option>
                                    <option value="Social" <?php selected($settings['category'], 'Social'); ?>>Social</option>
                                    <option value="Global" <?php selected($settings['category'], 'Global'); ?>>Global</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><?php echo esc_html__('List Mode', 'cancer-awareness-ribbon'); ?></th>
                            <td>
                                <label>
                                    <input type="checkbox" name="list" value="1" class="car-field" <?php checked((int)$settings['list'], 1); ?> />
                                    <?php echo esc_html__('Show all ribbons for month', 'cancer-awareness-ribbon'); ?>
                                </label>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><label for="car_class"><?php echo esc_html__('Extra CSS Class', 'cancer-awareness-ribbon'); ?></label></th>
                            <td>
                                <input id="car_class" name="class" type="text" value="<?php echo esc_attr((string)$settings['class']); ?>" class="regular-text car-field" />
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <p>
                        <button type="submit" name="car_save_settings" class="button button-primary">
                            <?php echo esc_html__('Save Defaults', 'cancer-awareness-ribbon'); ?>
                        </button>
                    </p>
                </form>

                <h3><?php echo esc_html__('Generated Shortcode', 'cancer-awareness-ribbon'); ?></h3>
                <div class="car-shortcode-row">
                    <input type="text" id="car_shortcode_output" class="large-text" readonly value="" />
                    <button class="button" id="car_copy_shortcode"><?php echo esc_html__('Copy', 'cancer-awareness-ribbon'); ?></button>
                </div>
                <p class="description"><?php echo esc_html__('Copy and paste into any page/post, or use builder widgets/modules.', 'cancer-awareness-ribbon'); ?></p>
            </div>

            <div class="car-admin-card">
                <h2><?php echo esc_html__('Live Preview', 'cancer-awareness-ribbon'); ?></h2>
                <div id="car_preview" class="car-preview-box">
                    <?php
                    // Initial server-side preview using saved defaults
                    echo car_render_awareness_ribbon($settings);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}

/**
 * AJAX: return preview HTML + shortcode string
 */
function car_admin_ajax_preview(): void
{
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'Forbidden'], 403);
    }

    $nonce = isset($_POST['nonce']) ? (string)$_POST['nonce'] : '';
    if (!wp_verify_nonce($nonce, 'car_admin_nonce')) {
        wp_send_json_error(['message' => 'Bad nonce'], 400);
    }

    $atts = [
        'type'     => isset($_POST['type']) ? sanitize_key((string)$_POST['type']) : '',
        'month'    => isset($_POST['month']) ? (string)$_POST['month'] : '',
        'size'     => isset($_POST['size']) ? (string)$_POST['size'] : '64',
        'label'    => !empty($_POST['label']) ? '1' : '0',
        'category' => isset($_POST['category']) ? car_normalize_category($_POST['category']) : '',
        'list'     => !empty($_POST['list']) ? '1' : '0',
        'class'    => isset($_POST['class']) ? sanitize_html_class((string)$_POST['class']) : '',
    ];

    // Build shortcode output
    $parts = ['[cancer_ribbon'];
    foreach ($atts as $k => $v) {
        if ($v === '' || $v === '0') continue; // keep shortcode clean
        $parts[] = $k . '="' . esc_attr($v) . '"';
    }
    $parts[] = ']';
    $shortcode = implode(' ', $parts);

    $html = car_render_awareness_ribbon($atts);

    wp_send_json_success([
        'shortcode' => $shortcode,
        'html'      => $html,
    ]);
}
add_action('wp_ajax_car_admin_preview', 'car_admin_ajax_preview');

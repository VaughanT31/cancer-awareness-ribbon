=== Cancer Awareness Ribbon Shortcode ===
Contributors: freelancedirectza
Tags: cancer, nonprofit, ribbon, shortcode, accessibility
Requires at least: 5.8
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.5.1
Version: 1.5.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Scalable awareness ribbon shortcode with monthly colors, gradients, category filtering, and month list mode.

== Description ==

**Cancer Awareness Ribbon Shortcode** is a lightweight WordPress plugin that adds a shortcode for displaying a professionally designed awareness ribbon anywhere on your website.

[Live Demo](https://www.parallelmedia.co.za/cancer-awareness-ribbon-demo/)

The ribbon automatically adapts to the current awareness month and supports a wide range of awareness types including Cancer, Medical, Social, and Global causes.

The ribbon:
- Automatically changes color based on the current awareness month
- Supports single-color and multi-color (gradient) ribbons
- Uses a clean, scalable SVG with no background
- Works seamlessly with Elementor, Divi, WPBakery, Beaver Builder, Gutenberg, headers, footers, and widgets
- Includes a built-in admin shortcode builder with live preview
- Scales crisply at any size
- Does not rely on external libraries or image files
- Includes accessibility-friendly ARIA labels

This plugin is ideal for:
- Awareness campaigns
- Non-profits and charities
- Medical practices
- Schools and community organizations
- Corporate social responsibility initiatives
- Site-wide awareness displays

Version 1.5.0 introduces:
- Admin settings page with live shortcode preview
- Default ribbon settings (size, type, month, category, label, list mode)
- Internal data structure refactor from cancer-only to awareness types
- Developer filter hook for registering custom awareness ribbons
- Improved builder integrations (Elementor, Divi, WPBakery, Beaver Builder)
- Foundation for future Pro features

== Features ==

* Automatic ribbon selection based on the current month
* Supports Cancer, Medical, Social, and Global awareness types
* Multi-color gradient support for applicable ribbons
* Fully responsive SVG (no images required)
* Admin shortcode builder with live preview
* Save default ribbon display settings
* Compatible with major page builders
* Lightweight and fast (no external libraries)
* Accessible SVG with ARIA labels
* Customizable size, label, type, month, category filtering, and month listing via shortcode attributes
* Developer hook to extend awareness ribbon library

== Usage ==

Insert the ribbon anywhere using the shortcode:

[cancer_ribbon]

=== Optional Shortcode Attributes ===

[cancer_ribbon size="64"]
[cancer_ribbon label="1"]
[cancer_ribbon type="breast_cancer"]
[cancer_ribbon month="10"]

[cancer_ribbon category="Medical"]
[cancer_ribbon list="1" month="11" label="1"]
[cancer_ribbon list="1" month="10" category="Social" label="1"]

**Available attributes:**

* `size` – Size in pixels (default: 64)
* `label` – Show label text (1 or 0)
* `type` – Force a specific ribbon type key
* `month` – Force a specific month (1–12)
* `category` – Filter by category: Cancer, Medical, Social, Global (optional)
* `list` – If set to 1/true, lists all ribbons for the selected month (optional)

== Admin Shortcode Builder ==

Version 1.5.0 adds a top-level **Awareness Ribbon** admin page where you can:

- Select ribbon type
- Choose month or auto-detect
- Adjust ribbon size
- Enable label display
- Filter by category
- Enable list mode
- Add custom CSS class
- View live preview instantly
- Copy generated shortcode
- Save global defaults

== Developer Extensibility ==

Developers can extend the ribbon library using a filter hook:



    add_filter( 'car_awareness_types', 'my_custom_awareness_ribbon' );
    function my_custom_awareness_ribbon( $types ) {
        $types['my_custom_cause'] = array(
            'label'    => 'My Custom Cause',
            'month'    => 6,
            'colors'   => array( '#123456', '#abcdef' ),
            'category' => 'Global',
        );
        return $types;
    }


This allows plugins and themes to register custom awareness ribbons without modifying core plugin files.

== Supported Awareness Types ==

The plugin includes ribbon colors for many cancer awareness months and additional awareness types.

Examples include:

- Breast Cancer (October) – Pink
- Prostate Cancer (September) – Light Blue
- Childhood Cancer (September) – Gold
- Lung Cancer (November) – White
- Colorectal Cancer (March) – Dark Blue
- Pancreatic Cancer (November) – Purple
- Cervical Cancer (January) – Teal & White
- Thyroid Cancer (September) – Purple, Teal & Pink

Additional awareness ribbons include (among others):

- HIV / AIDS Awareness
- Autism Awareness
- Mental Health Awareness
- Diabetes Awareness
- Heart Disease Awareness
- Domestic Violence Awareness
- Alzheimer’s Awareness
- Pride Awareness (multi-color)
- Anti-Bullying Awareness
- Organ Donation Awareness
- Veterans Awareness
- Child Protection Awareness

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/`
2. Activate **Cancer Awareness Ribbon Shortcode** via the Plugins menu
3. Add `[cancer_ribbon]` anywhere on your site

Or install directly from the WordPress plugin repository.

== Frequently Asked Questions ==

= Does this work with page builders? =
Yes. It works with Elementor, Divi, WPBakery, Beaver Builder, Gutenberg, and any builder that supports shortcodes.

= Does it add any images or external files? =
No. The ribbon is rendered as an inline SVG for maximum performance and quality.

= Can I force a specific ribbon regardless of month? =
Yes. Use the `type` attribute in the shortcode.

= Can I filter by category? =
Yes. Use `category="Cancer"`, `category="Medical"`, `category="Social"`, or `category="Global"`.

= Can I list all awareness ribbons for a selected month? =
Yes. Use `list="1"` and a month, for example: `[cancer_ribbon list="1" month="11" label="1"]`.

= Will this affect my site performance? =
No. The plugin is extremely lightweight and outputs minimal markup.

= Is the ribbon background transparent? =
Yes. The SVG has no background or shadow by default.

== Screenshots ==

1. Awareness ribbon displayed in a site footer
2. Breast cancer awareness ribbon (October)
3. Multi-color gradient ribbon example
4. Elementor module integration
5. Admin shortcode builder with live preview
6. Month listing view (list mode) showing multiple ribbons

== Changelog ==

= 1.5.0 =
* Added admin shortcode builder with live preview
* Added global default ribbon settings
* Refactored internal data structure from cancer-only to awareness types
* Added developer filter hook for registering custom awareness ribbons
* Added full builder integrations (Elementor, Divi, WPBakery, Beaver Builder)
* Improved internal structure for future Pro version expansion

= 1.4.0 =
* Added awareness categories: Cancer, Medical, Social, Global
* Added `category` shortcode attribute for filtering
* Added `list` shortcode attribute to display all ribbons for a selected month
* Added grouped output by category when using list mode

= 1.3.0 =
* Added Pride awareness ribbon
* Added Veterans awareness ribbon
* Added Child Protection awareness ribbon
* Added Anti-Bullying awareness ribbon
* Added Organ Donation awareness ribbon

= 1.2.0 =
* Added Domestic Violence awareness ribbon
* Added Prostate Health awareness ribbon
* Added Ovarian Health awareness ribbon
* Added Lung Health awareness ribbon
* Added Alzheimer’s awareness ribbon

= 1.1.0 =
* Added HIV / AIDS awareness ribbon
* Added Autism awareness ribbon
* Added Mental Health awareness ribbon
* Added Diabetes awareness ribbon
* Added Heart Disease awareness ribbon

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.5.0 =
Adds admin shortcode builder, default settings support, internal awareness refactor, developer extensibility hook, and builder integrations.

== License ==

This plugin is licensed under the GPLv2 or later.


You are free to modify and redistribute this plugin under the same license.

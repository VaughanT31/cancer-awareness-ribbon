=== Cancer Awareness Ribbon Shortcode ===
Contributors: parallelmedia
Tags: cancer, awareness, ribbon, shortcode, accessibility
Requires at least: 5.8
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.0.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Display a beautiful, scalable cancer awareness ribbon that automatically changes color based on the current awareness month.

== Description ==

**Cancer Awareness Ribbon Shortcode** is a lightweight WordPress plugin that adds a shortcode for displaying a professionally designed cancer awareness ribbon.

The ribbon:
- Automatically changes color based on the current awareness month
- Supports single-color and multi-color (gradient) ribbons
- Uses a clean SVG with no background
- Works perfectly with Elementor, Gutenberg, headers, footers, and widgets
- Scales crisply at any size
- Does not rely on external assets or libraries

This plugin is ideal for:
- Awareness campaigns
- Non-profits
- Medical practices
- Corporate social responsibility pages
- Footer or site-wide awareness displays

== Features ==

* Automatic ribbon color based on month
* Multi-color gradient support for applicable cancers
* Fully responsive SVG (no images required)
* Elementor Shortcode widget compatible
* Lightweight and fast
* Accessible SVG with ARIA labels
* Customizable size, label, and type via shortcode attributes

== Usage ==

Insert the ribbon anywhere using the shortcode:

[cancer_ribbon]

### Optional Shortcode Attributes

[cancer_ribbon size="64"]
[cancer_ribbon label="1"]
[cancer_ribbon type="breast_cancer"]
[cancer_ribbon month="10"]


**Available attributes:**

* `size` – Size in pixels (default: 64)
* `label` – Show cancer label text (1 or 0)
* `type` – Force a specific cancer ribbon
* `month` – Force a specific month (1–12)

== Supported Awareness Colors ==

The plugin includes accurate ribbon colors for major cancer awareness months, including:

- Breast Cancer (October) – Pink
- Prostate Cancer (September) – Light Blue
- Childhood Cancer (September) – Gold
- Lung Cancer (November) – White
- Colorectal Cancer (March) – Dark Blue
- Pancreatic Cancer (November) – Purple
- Cervical Cancer (January) – Teal & White
- Thyroid Cancer (September) – Purple, Teal & Pink
- And many more

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/`
2. Activate **Cancer Awareness Ribbon** via the Plugins menu
3. Add `[cancer_ribbon]` anywhere on your site

Or install directly from the WordPress plugin repository.

== Frequently Asked Questions ==

= Does this work with Elementor? =
Yes. Use Elementor’s **Shortcode** widget and insert `[cancer_ribbon]`.

= Does it add any images or external files? =
No. The ribbon is rendered as an inline SVG for maximum performance and quality.

= Can I force a specific ribbon regardless of month? =
Yes. Use the `type` attribute in the shortcode.

= Will this affect my site performance? =
No. The plugin is extremely lightweight and outputs minimal markup.

= Is the ribbon background transparent? =
Yes. The SVG has no background or shadow by default.

== Screenshots ==

1. Cancer awareness ribbon displayed in a site footer
2. Breast cancer awareness ribbon (October)
3. Multi-color gradient ribbon example
4. Elementor Shortcode widget usage

== Changelog ==

= 1.0.1 =
* Added support for custom SVG ribbon
* Improved Elementor compatibility
* Fixed inline CSS loading issues
* Removed background elements from SVG

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.0.1 =
Improved SVG accuracy, styling reliability, and Elementor compatibility.

== License ==

This plugin is licensed under the GPLv2 or later.

You are free to modify and redistribute this plugin under the same license.
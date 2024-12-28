# Headless WordPress Plugin

A lightweight plugin designed for decoupled WordPress setups, where the CMS serves as a backend API, and the frontend is handled by a separate framework (e.g., React, Angular, Vue). This plugin removes unnecessary WordPress features for a headless environment.

## Features

- **Appearance Menu Removal:** Hides the "Appearance" menu from the WordPress admin panel, ensuring themes are no longer editable or changeable.
- **Theme Switching Disabled:** Prevents users from switching themes by blocking access to the theme switching interface.
- **Frontend Disabled:** Completely disables the traditional WordPress frontend, allowing the site to operate as an API-only backend.
- **Unnecessary Features Disabled:** Removes REST API discovery links, oEmbed links, and WordPress version meta tags from the header.

## How It Works

1. **Appearance Menu Removal:**
   The plugin removes the "Appearance" menu from the WordPress admin panel using the `remove_menu_page` function.

2. **Theme Switching Disabled:**
   Access to the theme switching interface is blocked by hooking into `load-themes.php` and displaying a message.

3. **Frontend Disabled:**
   The plugin redirects all frontend requests to a message indicating the site is API-only, using the `template_redirect` hook.

4. **Unnecessary Features Disabled:**
   Various unnecessary frontend features, like WordPress version disclosure and REST API discovery links, are removed for a cleaner API experience.

## Installation

1. Download the plugin.
2. Upload the plugin folder to the `/wp-content/plugins/` directory.
3. Activate the plugin through the "Plugins" menu in WordPress.

## Code Overview

```php
<?php
/*
* Plugin Name: Headless WordPress
* Plugin URI: https://wpflames.com/
* Description: Remove appearance menu, disable theme switching, disable frontend
* Version: 1.0.0
* Author: Gabor Flamich
* Author URI: https://gaborflamich.com
* Text Domain: wpflames
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Megjelenés menü elrejtése
function remove_appearance_menu() {
    remove_menu_page('themes.php');
}
add_action('admin_menu', 'remove_appearance_menu', 999);

// Sablonváltás tiltása
function disable_theme_switching() {
    wp_die(__('A sablonváltás tiltva van ebben a környezetben.'));
}
add_action('load-themes.php', 'disable_theme_switching');

// Frontend teljes kikapcsolása
function disable_frontend() {
    if (!is_admin()) {
        wp_die(__('Ez az oldal csak API-ként használható.'));
    }
}
add_action('template_redirect', 'disable_frontend');

// REST API-on kívüli funkciók tiltása
function disable_unnecessary_wp_features() {
    remove_action('wp_head', 'wp_generator'); // WordPress verzió eltávolítása
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
}
add_action('init', 'disable_unnecessary_wp_features');
```

## Contributing

If you have suggestions for improving this plugin, feel free to open an issue or submit a pull request on GitHub.

## License

This plugin is open-source and available under the [GPL-2.0-or-later](https://www.gnu.org/licenses/gpl-2.0.html) license.

---

### Author

**Gabor Flamich**  
[Website](https://gaborflamich.com)  
[WP Flames](https://wpflames.com)

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

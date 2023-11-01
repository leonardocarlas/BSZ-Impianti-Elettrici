<?php

/*
 * Plugin Name:       Negozio Plugin
 * Plugin URI:        https://leonardocarlassare.com
 * Description:       Plugin per mostrare gli articoli in vendita dell'azienda.
 * Version:           0.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Leonardo Carlassare
 * Author URI:        https://leonardocarlassare.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       negozio-plugin
 * Domain Path:       /languages
 */


add_shortcode('wporg', 'wporg_shortcode');
function wporg_shortcode( $atts = [], $content = null) {
    // do something to $content
    // always return
    return $content;
}

// add_shortcode('items_grid', 'custom_items_grid');
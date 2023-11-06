<?php

require_once 'public/index.php';


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

if ( ! defined('ABSPATH') ) 
{
    exit;
}

if ( ! class_exists('Negozio') ) {
    class Negozio {
        public static function init() {

        }
    }
    
    Negozio::init();

}

function hello_world_content($content) {
    // Aggiungi il messaggio "Ciao, mondo!" all'inizio del contenuto della pagina
    $message = '<p>Ciao, mondo!</p>';
    $content = $message . $content;
    return $content;
}

// Aggiungi il filtro al contenuto della pagina
// add_filter('the_content', 'hello_world_content');



function wporg_shortcode( $atts = [], $content = null) {
    // do something to $content
    // always return
    $t = new Template();
    return $t->get_name();
}

add_shortcode('wporg', 'wporg_shortcode');
new Negozio;

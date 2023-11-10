<?php

require_once get_template_directory() . '/components/item.php';


function include_custom_js() {
    // Definisci il percorso del file JavaScript
    $js_file_path = get_template_directory_uri() . '/components/item.js';

    // Registra lo script
    wp_register_script('custom-js', $js_file_path, array('jquery'), '1.0', true);

    // Includi lo script nel footer del tuo sito
    wp_enqueue_script('custom-js');
}


// Codice PHP personalizzato qui
function custom_shortcode_function($atts)
{
    return "Questo è il mio shortcode personalizzato! Leonardo";
}

function custom_items_grid($atts)
{
    $items = [
        new Item("Modulo Megatiker me160b", "https://www.ebay.it/itm/285503773076", "https://www.bszimpianti.it/wp-content/uploads/2023/11/megatiker-me160b.jpeg"),
        new Item("Modulo Bticino ma125", "https://www.ebay.it/itm/285503773076", "https://www.bszimpianti.it/wp-content/uploads/2023/11/bticino-ma125.jpeg"),
        new Item("Faretto per proiettore", "https://www.ebay.it/itm/285503773076", "https://www.bszimpianti.it/wp-content/uploads/2023/11/faretto-per-proiettore.jpeg"),
        new Item("Modulo Bticino gs125", "https://www.ebay.it/itm/285503773076", "https://www.bszimpianti.it/wp-content/uploads/2023/11/bticino-gs125.jpeg"),
        new Item("Modulo Bticino gs125 500V", "https://www.ebay.it/itm/285503773076", "https://www.bszimpianti.it/wp-content/uploads/2023/11/bticino-gs125-500v.jpeg"),

    ];
    $gridTemplate = '
    <style>
        .welcome-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* 3 items in a column */
            gap: 20px; /* Adjust the gap between items as needed */
        }
        
        /* Optional: Add media queries for responsiveness */
        @media (max-width: 768px) {
            .welcome-container {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* 2 items in a column for smaller screens */
            }
        }
        
        @media (max-width: 480px) {
            .welcome-container {
                grid-template-columns: 1fr; /* 1 item in a column for even smaller screens */
            }
        }
    </style>

    <div class="welcome-container">';
    foreach ($items as $item) {
        $gridTemplate .= '<item-component title="' . $item->title . '" imageLink="' . $item->imageLink . '" ebayLink="' . $item->ebayLink . '"></item-component>';
    }
    $gridTemplate .= '</div>';
    return $gridTemplate;
}

add_shortcode('mio_shortcode', 'custom_shortcode_function');
add_shortcode('items_grid', 'custom_items_grid');
// add_shortcode('my_title', 'custom_html');



add_action('wp_enqueue_scripts', 'include_custom_js');
add_shortcode('my_jsfile', 'include_custom_js');

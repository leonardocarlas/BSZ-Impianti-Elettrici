<?php

include_once './components/grid.php';

echo Grid();

// Codice PHP personalizzato qui
function custom_shortcode_function($atts)
{
    // Tuo codice qui
    return "Questo è il mio shortcode personalizzato! Leonardo";
}

add_shortcode('mio_shortcode', 'custom_shortcode_function');
add_shortcode('items_negozio', 'Grid');

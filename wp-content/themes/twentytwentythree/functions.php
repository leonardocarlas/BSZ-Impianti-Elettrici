<?php


// Codice PHP personalizzato qui
function custom_shortcode_function($atts)
{
    // Tuo codice qui
    return "Questo è il mio shortcode personalizzato!";
}

add_shortcode('mio_shortcode', 'custom_shortcode_function');

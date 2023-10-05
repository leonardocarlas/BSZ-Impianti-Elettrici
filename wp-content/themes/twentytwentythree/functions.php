<?php


// Codice PHP personalizzato qui
function custom_shortcode_function($atts)
{
    // Tuo codice qui
    return "Questo è il mio shortcode personalizzato! Leonardo";
}

// Codice PHP personalizzato qui
function custom_html($atts)
{
    // Tuo codice qui
    return "<h2>Oggetti disponibili:</h2>";
}

add_shortcode('mio_shortcode', 'custom_shortcode_function');
add_shortcode('my_title', 'custom_html');


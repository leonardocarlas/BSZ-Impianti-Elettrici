# BSZ-Impianti-Elettrici

## Running a local server

php -S localhost:8000

## Note

- functions.php non funziona bene

'''
<?php
include_once 'components/grid.php';

$gridTemplate .= '<script type="text/javascript" src="./components/item.js" defer></script>';

echo $gridTemplate;

// Codice PHP personalizzato qui
function custom_shortcode_function($atts)
{
    return "Questo è il mio shortcode personalizzato! Leonardo";
}

function custom_html($atts)
{
    return "<h2>Oggetti disponibili:</h2>";
}

// function custom_items_grid($atts)
// {
//     return $gridTemplate;
// }

add_shortcode('mio_shortcode', 'custom_shortcode_function');
// add_shortcode('items_grid', 'custom_items_grid');
add_shortcode('my_title', 'custom_html');
'''
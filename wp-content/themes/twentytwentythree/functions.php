<?php

class Item
{
    public string $title;
    public string $ebayLink;
    public string $imageLink;

    public function __construct(string $title, string $ebayLink, string $imageLink)
    {
        $this->title = $title;
        $this->ebayLink = $ebayLink;
        $this->imageLink = $imageLink;
    }

    public function getInfo(): string
    {
        return "Questo item è una {$this->title}, con link {$this->ebayLink} e immagine {$this->imageLink}.";
    }
}



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
    $items = [new Item("Cavo rosso 1x2,5", "https://www.ebay.it/itm/285503773076", "https://i.ebayimg.com/images/g/mTcAAOSwtN9lHl0V/s-l1600.jpg")];
    $gridTemplate = '<div class="welcome-container">';
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

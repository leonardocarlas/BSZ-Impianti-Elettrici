<?php

include_once 'items.php';

// Codice PHP personalizzato qui
function Grid(): string
{

    $html = '
    <div class="welcome-container">
        <script type="text/javascript" src="./item.js"></script>
        <h2>Oggetti in vendita:</h2>';
    
    foreach ($items as $item) {
        $html .= '<item-component title="' . $item->title . '" imageLink="' . $item->imageLink . '" ebayLink="' . $item->ebayLink . '"></item-component>';
    }
    
    $html .= '</div>';
    

    // Tuo codice qui
    return "test negozio";
}
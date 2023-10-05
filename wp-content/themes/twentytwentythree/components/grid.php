<?php

include_once 'items.php';

$gridTemplate = '
<div class="welcome-container">

    <script type="text/javascript" src="./item.js" defer></script>
    <h2>Oggetti in vendita:</h2>
    ';
foreach ($items as $item) {
    $gridTemplate .= '<item-component title="' . $item->title . '" imageLink="' . $item->imageLink . '" ebayLink="' . $item->ebayLink . '"></item-component>';
}

$gridTemplate .= '</div>';

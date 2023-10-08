<?php

include_once 'items.php';

$gridTemplate = '
    <div class="welcome-container">';

foreach ($items as $item) {
    $gridTemplate .= '<item-component title="' . $item->title . '" imageLink="' . $item->imageLink . '" ebayLink="' . $item->ebayLink . '"></item-component>';
}

$gridTemplate .= '</div>';

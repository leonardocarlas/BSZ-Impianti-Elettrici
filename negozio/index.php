<?php include_once 'items.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Negozio | BSZ Impianti Elettrici</title>
    <link rel="stylesheet" href="../components/item.css">
    <script src="../components/item.js" type="text/javascript" defer></script>
</head>

<body>
    <div class="welcome-container">
        <h1>Negozio online</h1>
        <p>Grazie per averci visitato.</p>
        <p>Questa è una pagina di benvenuto di esempio creata con PHP.</p>
        <?php
        foreach ($items as $item) {
            echo $item->title . "<br>";
            echo '<item-component title="' . $item->title . '" imageLink="' . $item->imageLink . '" ebayLink="' . $item->ebayLink . '"></item-component>';
        }
        ?>
        <item-component title="Modulo 40w"></item-component>
    </div>
</body>

</html>
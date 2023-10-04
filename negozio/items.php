<?php

require_once 'item.php';

$items = [new Item("ciao", "ciao", "ciao")];

echo $items[0]->getInfo();

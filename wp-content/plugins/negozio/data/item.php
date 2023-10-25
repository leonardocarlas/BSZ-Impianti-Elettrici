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

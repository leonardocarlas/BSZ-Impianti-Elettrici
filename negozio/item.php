<?php

class Item
{
    private string $title;
    private string $ebayLink;
    private string $imageLink;

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

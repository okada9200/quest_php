<?php
class Player
{
    public $name;
    public $hand;

    public function __construct($name)
    {
        $this->name = $name;
        $this->hand = [];
    }

    public function drawCard($card)
    {
        $this->hand[] = $card;
    }

    public function playCard()
    {
        return array_pop($this->hand);
    }

    public function hasCards()
    {
        return count($this->hand) > 0;
    }
}

?>
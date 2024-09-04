<?php

namespace zephy\sell\extension;

use pocketmine\item\Item;

final class Saleable
{
    public function __construct(
        private Item $item,
        private int $price
    ) {}

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function save(): array
    {
        return [
            "price" => $this->getPrice()
        ];
    }
}

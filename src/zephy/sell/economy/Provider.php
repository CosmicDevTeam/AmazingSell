<?php

namespace zephy\sell\economy;

use pocketmine\player\Player;

abstract class Provider
{
    abstract public function getName(): string;

    abstract public function getClass();

    abstract public function addMoney(Player $player, int $cantity): void;
}

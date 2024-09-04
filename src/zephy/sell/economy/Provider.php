<?php

namespace zephy\sell\economy;

use pocketmine\player\Player;
use pocketmine\plugin\Plugin;

abstract class Provider
{
    abstract public function getName(): string;

    abstract public function getClass();

    abstract function isEnabled(): ?Plugin;

    abstract public function addMoney(Player $player, int $cantity): void;
}

<?php

namespace zephy\sell\economy\types;

use onebone\economyapi\EconomyAPI;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use zephy\sell\economy\Provider;

class EconomyAPIProvider extends Provider
{
    public function getName(): string
    {
        return "economy-api";
    }

    public function getClass(): EconomyAPI
    {
        return EconomyAPI::getInstance();
    }

    public function isEnabled(): ?Plugin
    {
        return Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI");
    }

    public function addMoney(Player $player, int $cantity): void
    {
        $this->getClass()->addMoney($player, $cantity);
    }
}

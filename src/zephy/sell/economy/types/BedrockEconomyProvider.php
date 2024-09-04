<?php

namespace zephy\sell\economy\types;

use cooldogedev\BedrockEconomy\api\BedrockEconomyAPI;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use zephy\sell\economy\Provider;

class BedrockEconomyProvider extends Provider
{
    public function getName(): string
    {
        return "bedrock_economy";
    }

    public function getClass()
    {
        return BedrockEconomyAPI::legacy();
    }

    public function isEnabled(): ?Plugin
    {
        return Server::getInstance()->getPluginManager()->getPlugin("BedrockEconomy");
    }
    public function addMoney(Player $player, int $cantity): void
    {
        $this->getClass()->addToPlayerBalance($player->getName(), $cantity);
    }
}

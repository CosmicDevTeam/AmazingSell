<?php

namespace zephy\sell\economy\types;

use cooldogedev\BedrockEconomy\api\BedrockEconomyAPI;
use pocketmine\player\Player;
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

    public function addMoney(Player $player, int $cantity): void
    {
        $this->getClass()->addToPlayerBalance($player->getName(), $cantity);
    }
}

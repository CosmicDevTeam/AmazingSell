<?php

namespace zephy\sell\utils;

use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\player\Player;
use pocketmine\utils\SingletonTrait;

final class Utils
{
    use SingletonTrait {
        setInstance as private;
        reset as private;
    }

    public function playSound(Player $player, string $sound)
    {
        $pk = new PlaySoundPacket;
        $pk->soundName = $sound;
        $pk->pitch = 1.0;
        $pk->volume = 1.0;
        $pk->x = $player->getPosition()->getX();
        $pk->y = $player->getPosition()->getY();
        $pk->z = $player->getPosition()->getZ();

        $player->getNetworkSession()->sendDataPacket($pk);
    }
}

<?php

namespace zephy\sell\utils;

use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\player\Player;

class SoundUtils {
    public static function playSound(Player $player, string $sound){
        $pos = $player->getPosition();
        $pk = PlaySoundPacket::create(
            $sound, 
            $pos->x, 
            $pos->y, 
            $pos->z, 
            1.0, 
            1.0
        );

        $player->getNetworkSession()->sendDataPacket($pk);

    }
}
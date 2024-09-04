<?php

namespace zephy\sell\utils;

use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use zephy\sell\Loader;

final class MessageUtils
{
    public static function formatMessage(string $message, array $variablesFeas = [])
    {

        foreach ($variablesFeas as $key => $reemplaza) {
            $message = str_replace($key, $reemplaza, $message);
        }

        return TextFormat::colorize($message);
    }

    public static function getMessage(): ?Config
    {
        return (new Config(Loader::getInstance()->getDataFolder() . "messages.yml", Config::YAML));
    }
}

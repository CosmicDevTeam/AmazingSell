<?php

namespace zephy\sell;

use CortexPE\Commando\PacketHooker;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use zephy\sell\commands\SellCommand;
use zephy\sell\economy\ProviderManager;
use zephy\sell\items\SaleableFactory;

class Loader extends PluginBase
{
    use SingletonTrait {
        setInstance as private;
        reset as private;
    }
    protected function onEnable(): void {
        self::setInstance($this);

        if(!PacketHooker::isRegistered()) {
            PacketHooker::register($this);
        }
        Server::getInstance()->getCommandMap()->register("AmazingSell", new SellCommand);

        $this->saveResource("messages.yml");
        
        SaleableFactory::getInstance()->load();

        ProviderManager::getInstance()->setEconomy($this->getConfig()->get("economy-provider"));
    }

    protected function onDisable(): void
    {
        SaleableFactory::getInstance()->save();
    }
}

<?php

namespace zephy\sell\economy;

use pocketmine\plugin\PluginException;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use zephy\sell\economy\types\BedrockEconomyProvider;
use zephy\sell\economy\types\EconomyAPIProvider;
use zephy\sell\Loader;

final class ProviderManager
{
    use SingletonTrait {
        setInstance as private;
        reset as private;
    }

    private array $economy;
    private array $defaultTypes = [
        "economy-api",
        "bedrock_economy"
    ];

    public function setEconomy(string $economy): void
    {
        $this->isDependencyEnabled();
        $this->economy = $economy;
    }

    public function isDependencyEnabled(): void
    {
        if(!in_array($this->economy, $this->defaultTypes)) {
            throw new PluginException($this->economy . " is not a economy plugin");
        }
        if (is_null(Server::getInstance()->getPluginManager()->getPlugin("BedrockEconomy")) or is_null(Server::getInstance()->getPluginManager()->getPlugin("BedrockEconomy"))) {
            throw new PluginException("EconomyDependency Plugin Not Found");
        }
    }

    # sugerencias?

    public function getEconomy(): Provider
    {
        return match ($this->economy) {
            "economy-api" => new EconomyAPIProvider(),
            "bedrock_economy" => new BedrockEconomyProvider()
        };
    }
}

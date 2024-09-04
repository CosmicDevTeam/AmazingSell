<?php

namespace zephy\sell\items;

use pocketmine\item\Item;
use pocketmine\item\StringToItemParser;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use UnexpectedValueException;
use zephy\sell\extension\Saleable;
use zephy\sell\Loader;

final class SaleableFactory
{
    use SingletonTrait {
        setInstance as private;
        reset as private;
    }

    private array $items = [];

    private Config $config;

    public function __construct()
    {
        $this->config = new Config(Loader::getInstance()->getDataFolder() . "data.json", Config::JSON);
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(Item $item, int $price): void
    {
        $this->items[$item->getVanillaName()] = new Saleable($item, $price);
    }

    public function getItem(string $item): ?Saleable
    {
        return $this->items[$item] ?? null;
    }

    public function destroy(string $item): void
    {
        unset($this->items[$item]);
    }

    public function save(): void
    {
        foreach ($this->getItems() as $item) {
            $name = StringToItemParser::getInstance()->lookupAliases($item->getItem())[0];
            $this->config->set($name, $item->save());
        }

        $this->config->save();
    }
    public function load(): void
    {

        foreach ($this->config->getAll() as $item => $data) {
            $item = StringToItemParser::getInstance()->parse($item);

            if (is_null($item)) {
                throw new UnexpectedValueException("Expected a Item instance null given");
            }

            $this->addItem($item, $data["price"]);
        }
    }
}

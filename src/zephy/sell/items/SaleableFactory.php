<?php

namespace zephy\sell\items;

use Exception;
use pocketmine\item\Item;
use pocketmine\item\StringToItemParser;
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
        unset($this->items[array_search($item, $this->items)]);
    }

    public function save(): void
    {
        $config = new Config(Loader::getInstance()->getDataFolder() . "data.json", Config::JSON);
        foreach ($this->getItems() as $name => $item) {
            $config->set($name, $item->save());
            $config->save();
        }
    }
    public function load(): void
    {
        $config = new Config(Loader::getInstance()->getDataFolder() . "data.json", Config::JSON);
        foreach ($config->getAll() as $item => $data) {
            $item = StringToItemParser::getInstance()->parse($item);

            if (is_null($item)) {
                throw new UnexpectedValueException("Expected a Item instance null given");
            }

            $this->addItem($item, $data["price"]);
        }
    }
}

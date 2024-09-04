<?php

namespace zephy\sell\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use zephy\sell\economy\ProviderManager;
use zephy\sell\items\SaleableFactory;
use zephy\sell\utils\PermissionUtils;

class InventorySubCommand extends BaseSubCommand
{
    public function __construct()
    {
        parent::__construct("inventory", "Sell items in your inventory");
        $this->setPermission(PermissionUtils::DEFAULT);
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!$sender instanceof Player) return;

        $inventory = $sender->getInventory();

        foreach ($inventory->getContents() as $item) {
            if (SaleableFactory::getInstance()->getItem($item->getVanillaName()) !== null) {
                $saleable = SaleableFactory::getInstance()->getItem($item->getVanillaName());
                ProviderManager::getInstance()->getEconomy()->addMoney($sender, ($saleable->getPrice() * $item->getCount()));
                $sender->getInventory()->removeItem($item);
            }
        }
    }

    protected function prepare(): void {}
}

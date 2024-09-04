<?php

namespace zephy\sell\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use zephy\menu\utils\SoundUtils;
use zephy\sell\economy\ProviderManager;
use zephy\sell\items\SaleableFactory;
use zephy\sell\utils\MessageUtils;
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
        $selled = 0;
        foreach ($inventory->getContents() as $item) {
            if (SaleableFactory::getInstance()->getItem($item->getVanillaName()) !== null) {
                $saleable = SaleableFactory::getInstance()->getItem($item->getVanillaName());
                ProviderManager::getInstance()->getEconomy()->addMoney($sender, ($saleable->getPrice() * $item->getCount()));
                $selled += ($saleable->getPrice() * $item->getCount());
                $sender->getInventory()->removeItem($item);
            }
        }


        $sender->sendMessage(MessageUtils::formatMessage(MessageUtils::getMessage()->get("success-selled-count"), [
            "{PRICE}" => $selled
        ]));
        SoundUtils::playSound($sender, MessageUtils::getMessage()->get("error-sound"));
        return;
    }

    protected function prepare(): void {}
}

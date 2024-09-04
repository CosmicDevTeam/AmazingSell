<?php

namespace zephy\sell\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use zephy\sell\economy\ProviderManager;
use zephy\sell\items\SaleableFactory;
use zephy\sell\utils\MessageUtils;
use zephy\sell\utils\PermissionUtils;
use zephy\sell\utils\Utils;

class HandSubCommand extends BaseSubCommand
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

        if ($inventory->getItemInHand()->isNull()) {
            $sender->sendMessage(MessageUtils::formatMessage(MessageUtils::getMessage()->get("error-item-hand")));
            return;
        }
        $item = clone $inventory->getItemInHand();
        if (SaleableFactory::getInstance()->getItem($item->getVanillaName()) === null) {
            $sender->sendMessage(MessageUtils::formatMessage(MessageUtils::getMessage()->get("error-not-saleable")));
            return;
        }
        $saleable = SaleableFactory::getInstance()->getItem($item->getVanillaName());
        ProviderManager::getInstance()->getEconomy()->addMoney($sender, ($saleable->getPrice() * $item->getCount()));
        $sender->sendMessage(MessageUtils::formatMessage(MessageUtils::getMessage()->get("success-item-selled"), [
            "{COUNT}" => $item->getCount(),
            "{ITEM}" => $item->getVanillaName(),
            "{MONEY}" => ($saleable->getPrice() * $item->getCount())
        ]));
        return;
    }

    protected function prepare(): void {}
}

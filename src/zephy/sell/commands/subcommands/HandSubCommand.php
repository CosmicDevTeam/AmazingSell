<?php

namespace zephy\sell\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use zephy\menu\utils\SoundUtils;
use zephy\sell\economy\ProviderManager;
use zephy\sell\items\SaleableFactory;
use zephy\sell\utils\MessageUtils;
use zephy\sell\utils\PermissionUtils;
use zephy\sell\utils\Utils;

class HandSubCommand extends BaseSubCommand
{
    public function __construct()
    {
        parent::__construct("hand", "Sell items in your inventory");
        $this->setPermission(PermissionUtils::DEFAULT);
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!$sender instanceof Player) return;

        $inventory = $sender->getInventory();

        if ($inventory->getItemInHand()->isNull()) {
            $sender->sendMessage(MessageUtils::formatMessage(MessageUtils::getMessage()->get("error-item-hand")));
            SoundUtils::playSound($sender, MessageUtils::getMessage()->get("error-sound"));
            return;
        }
        $item = clone $inventory->getItemInHand();
        if (SaleableFactory::getInstance()->getItem($item->getVanillaName()) === null) {
            $sender->sendMessage(MessageUtils::formatMessage(MessageUtils::getMessage()->get("error-not-saleable")));
            SoundUtils::playSound($sender, MessageUtils::getMessage()->get("error-sound"));
            return;
        }

        $saleable = SaleableFactory::getInstance()->getItem($item->getVanillaName());
        ProviderManager::getInstance()->getEconomy()->addMoney($sender, ($saleable->getPrice() * $item->getCount()));

        $sender->getInventory()->setItemInHand(VanillaItems::AIR());

        $sender->sendMessage(MessageUtils::formatMessage(MessageUtils::getMessage()->get("success-item-selled"), [
            "{COUNT}" => $item->getCount(),
            "{ITEM}" => $item->getVanillaName(),
            "{MONEY}" => ($saleable->getPrice() * $item->getCount())
        ]));
        SoundUtils::playSound($sender, MessageUtils::getMessage()->get("success-sound"));
        return;
    }

    protected function prepare(): void {}
}

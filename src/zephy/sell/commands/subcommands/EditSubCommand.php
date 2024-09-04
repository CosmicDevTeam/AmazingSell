<?php

namespace zephy\sell\commands\subcommands;

use CortexPE\Commando\args\IntegerArgument;
use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use zephy\menu\utils\SoundUtils;
use zephy\sell\items\SaleableFactory;
use zephy\sell\utils\MessageUtils;
use zephy\sell\utils\PermissionUtils;

class EditSubCommand extends BaseSubCommand
{
    public function __construct()
    {
        parent::__construct("edit", "Edit the price of a saleable item");
        $this->setPermission(PermissionUtils::ADMIN);
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
        $saleable->setPrice($args["price"]);

        $sender->sendMessage(MessageUtils::formatMessage(MessageUtils::getMessage()->get("success-saleable-edited"), [
            "{ITEM}" => $item->getVanillaName(),
            "{PRICE}" => $saleable->getPrice()
        ]));
        SoundUtils::playSound($sender, MessageUtils::getMessage()->get("success-sound"));
        return;
    }

    protected function prepare(): void
    {
        $this->registerArgument(0, new IntegerArgument("price"));
    }
}

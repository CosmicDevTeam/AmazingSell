<?php

namespace zephy\sell\commands\subcommands;

use CortexPE\Commando\args\IntegerArgument;
use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use zephy\sell\items\SaleableFactory;
use zephy\sell\utils\MessageUtils;
use zephy\sell\utils\PermissionUtils;

class CreateSubCommand extends BaseSubCommand
{
    public function __construct()
    {
        parent::__construct("create", "Add a Saleable Item");
        $this->setPermission(PermissionUtils::ADMIN);
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {

        if (!isset($args["price"])) {
            $sender->sendMessage(MessageUtils::formatMessage(MessageUtils::getMessage()->get("invalids-arguments-create")));
            return;
        }

        if (!$sender instanceof Player) return;

        $inventory = $sender->getInventory();

        if ($inventory->getItemInHand()->isNull()) {
            $sender->sendMessage(MessageUtils::formatMessage(MessageUtils::getMessage()->get("error-item-hand")));
            return;
        }

        $saleable = SaleableFactory::getInstance()->getItem($inventory->getItemInHand()->getVanillaName());

        if (!is_null($saleable)) {
            $sender->sendMessage(MessageUtils::formatMessage(MessageUtils::getMessage()->get("error-already-registered"), [
                "{ITEM}" => $inventory->getItemInHand()->getVanillaName()
            ]));
            return;
        }

        SaleableFactory::getInstance()->addItem($inventory->getItemInHand(), $args["price"]);
        $sender->sendMessage(MessageUtils::formatMessage(MessageUtils::getMessage()->get("success-item-created"), [
            "{ITEM}" => $inventory->getItemInHand()->getVanillaName(),
            "{PRICE}" => $args["price"]
        ]));
        return;
    }

    protected function prepare(): void
    {
        $this->registerArgument(0, new IntegerArgument("price"));
    }
}
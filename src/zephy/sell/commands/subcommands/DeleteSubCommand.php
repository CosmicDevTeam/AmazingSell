<?php

namespace zephy\sell\commands\subcommands;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use zephy\sell\items\SaleableFactory;
use zephy\sell\utils\MessageUtils;
use zephy\sell\utils\PermissionUtils;

class DeleteSubCommand extends BaseSubCommand
{
    public function __construct()
    {
        parent::__construct("delete", "Delete a Seleable item");
        $this->setPermission(PermissionUtils::ADMIN);
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!isset($args["identifier"])) {
            $sender->sendMessage(MessageUtils::formatMessage(MessageUtils::getMessage()->get("invalids-arguments-delete")));
            return;
        }

        if (is_null(SaleableFactory::getInstance()->getItem($args["identifier"]))) {
            $sender->sendMessage(MessageUtils::formatMessage(MessageUtils::getMessage()->get("error-not-saleable")));
            return;
        }

        SaleableFactory::getInstance()->destroy($args["identifier"]);
        $sender->sendMessage(MessageUtils::formatMessage(MessageUtils::getMessage()->get("success-item-deleted"), [
            "{ITEM}" => $args["identifier"]
        ]));
        return;
    }

    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("identifier"));
    }
}

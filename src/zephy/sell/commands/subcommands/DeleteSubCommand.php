<?php

namespace zephy\sell\commands\subcommands;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use zephy\sell\utils\SoundUtils;
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
        if (!$sender instanceof Player) return;

        $inventory = $sender->getInventory();

        if ($inventory->getItemInHand()->isNull()) {
            $sender->sendMessage(MessageUtils::formatMessage(MessageUtils::getMessage()->get("error-item-hand")));
            SoundUtils::playSound($sender, MessageUtils::getMessage()->get("error-sound"));

            return;
        }

        SaleableFactory::getInstance()->destroy($inventory->getItemInHand()->getVanillaName());
        $sender->sendMessage(MessageUtils::formatMessage(MessageUtils::getMessage()->get("success-item-deleted"), [
            "{ITEM}" => $inventory->getItemInHand()->getVanillaName()
        ]));

        SoundUtils::playSound($sender, MessageUtils::getMessage()->get("success-sound"));
        return;
    }

    protected function prepare(): void {}
}

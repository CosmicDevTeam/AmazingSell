<?php

namespace zephy\sell\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use zephy\sell\utils\SoundUtils;
use zephy\sell\items\SaleableFactory;
use zephy\sell\utils\MessageUtils;
use zephy\sell\utils\PermissionUtils;

class ListSubCommand extends BaseSubCommand
{
    public function __construct()
    {
        parent::__construct("list", "Check all items saleable");
        $this->setPermission(PermissionUtils::DEFAULT);
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        $list = "&gSaleable List ";

        if (count(SaleableFactory::getInstance()->getItems()) < 1) {
            $list .= "\n&4No item Saleables";
        }

        foreach (SaleableFactory::getInstance()->getItems() as $items) {
            $list .= "\n&g" . $items->getItem()->getVanillaName() . " &fx1 for &a$" . $items->getPrice();
        }

        $sender->sendMessage(TextFormat::colorize($list));
        SoundUtils::playSound($sender, MessageUtils::getMessage()->get("success-sound"));
    }

    protected function prepare(): void {}
}

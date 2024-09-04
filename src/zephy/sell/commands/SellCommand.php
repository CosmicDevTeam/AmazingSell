<?php

namespace zephy\sell\commands;

use CortexPE\Commando\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use zephy\sell\commands\subcommands\CreateSubCommand;
use zephy\sell\commands\subcommands\DeleteSubCommand;
use zephy\sell\commands\subcommands\EditSubCommand;
use zephy\sell\commands\subcommands\HandSubCommand;
use zephy\sell\commands\subcommands\InventorySubCommand;
use zephy\sell\commands\subcommands\ListSubCommand;
use zephy\sell\Loader;
use zephy\sell\utils\PermissionUtils;

class SellCommand extends BaseCommand
{

    public function __construct()
    {
        parent::__construct(Loader::getInstance(), "sell", "Sell your items!");

        $this->setPermission(PermissionUtils::DEFAULT);
    }
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        $sender->sendMessage(TextFormat::colorize("&4Invalid Arguments"));
        return;
    }

    protected function prepare(): void
    {
        $this->registerSubCommand(new ListSubCommand);
        $this->registerSubCommand(new InventorySubCommand);
        $this->registerSubCommand(new HandSubCommand);
        $this->registerSubCommand(new DeleteSubCommand);
        $this->registerSubCommand(new CreateSubCommand);
        $this->registerSubCommand(new EditSubCommand);
    }
}

<?php

namespace IndexDev\IXPingCommand;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Main extends PluginBase {

    protected function onEnable(): void {
        $this->getServer()->getCommandMap()->register("ping", new PingCommand("ping", "Check your ping", "/ping", ["p"], "inping.cmd"));
    }
}

class PingCommand extends Command {

    public function __construct(string $name, string $description = "", string $usageMessage = "", array $aliases = [], string $permission = "") {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission("inping.cmd");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if (!$this->testPermission($sender)) {
            return true; 
        }

        if (!$sender instanceof Player) {
            $sender->sendMessage(TextFormat::RED . "This command can only be used in-game.");
            return true;
        }

        $ping = $sender->getNetworkSession()->getPing();
        $sender->sendMessage(TextFormat::GREEN . "Your ping: " . $ping . "ms");
        return true;
    }
}

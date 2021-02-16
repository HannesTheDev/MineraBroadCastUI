<?php

declare(strict_types=1);

namespace HannesTheDev\MineraBroadCastUI;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use jojoe77777\FormAPI\CustomForm;

class Main extends PluginBase
{

    const PREFIX = "§8[§c§lINFO§r§8] §a§l";

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool
    {
        switch ($command->getName()) {
            case "broadcast":
                if ($sender instanceof Player) {
                    if ($sender->hasPermission("minerabroadcastui.broadcast.cmd")) {
                        $this->openBroadCastUI($sender);
                    } else {
                        $sender->sendMessage("§8[§6§lMinera§r§8] §r§cYou don't have Permission to use this Command!");
                    }
                } else {
                    $sender->sendMessage("§8[§6§lMinera§r§8] §r§r§cYou must be a Player to use this Command!");
                }
                break;
        }
        return true;
    }

    public function openBroadCastUI(Player $player)
    {
        $form = new CustomForm(function (Player $player, $data = null) {
            if (!empty($data[2])) {
                if (!empty($data[1])) {
                    $this->getServer()->broadcastMessage("§8[§r" . $data[1] . "§r§8] §a§l" . $data[2]);
                } else {
                    $this->getServer()->broadcastMessage(Main::PREFIX . $data[2]);
                }
            } else {
                $player->sendMessage("§8[§6§lMinera§r§8] §r§cPlease enter something in the lines!");
            }
        });
        $form->setTitle("§8[§eBroadCastUI§8]");
        $form->addLabel("§7Sending a BroadCast message!");
        $form->addInput("§7Prefix:", "Empty for default");
        $form->addInput("§7Message:");
        $form->sendToPlayer($player);
        return $form;
    }
}
<?php

namespace Jason8831\Repair\Commands;

use Jason8831\Repair\Main;
use Jason8831\Repair\Manager\fonction;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Durable;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class Repair extends Command
{

    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
            $configYml = new Config(Main::getInstance()->getDataFolder() . "config.yml", Config::YAML);
            if ($sender instanceof Player){
                if ($sender->hasPermission("repair.use")){
                    if (!isset($args[0])){
                        if (Main::getCooldown()->exists($sender->getXuid() . "-repair")){
                            if (time() >= Main::getCooldown()->get($sender->getXuid() . "-repair")){
                                $item = $sender->getInventory()->getItemInHand();
                                if ($item instanceof Durable){
                                    if ($item->getDamage() >= 5){
                                        $item->setDamage(0);
                                        $sender->getInventory()->setItemInHand($item);
                                        $config = Main::getCooldown();
                                        $config->set($sender->getXuid() . "-repair", time() + $configYml->get("CooldownRepair"));
                                        $config->save();
                                        return;
                                    }else{
                                        $sender->sendMessage($configYml->get("NoRepairUse"));
                                        return;
                                    }
                                }else{
                                    $sender->sendMessage($configYml->get("NoDurabilityItem"));
                                    return;
                                }
                            }else{
                                $message = str_replace("{time}" , fonction::convert(Main::getCooldown()->get($sender->getXuid() . "-repair") - time()) . "." , $configYml->get("NoTimeUseRepair"));
                                $sender->sendMessage($message);
                                return;
                            }
                        }else{
                            $item = $sender->getInventory()->getItemInHand();
                            if ($item instanceof Durable){
                                if ($item->getDamage() >= 5){
                                    $item->setDamage(0);
                                    $sender->getInventory()->setItemInHand($item);
                                    $config = Main::getCooldown();
                                    $config->set($sender->getXuid() . "-repair", time() + $configYml->get("CooldownRepair"));
                                    $config->save();
                                    return;
                                }else{
                                    $sender->sendMessage($configYml->get("NoRepairUse"));
                                    return;
                                }
                            }else{
                                $sender->sendMessage($configYml->get("NoDurabilityItem"));
                                return;
                            }
                        }
                    }else{
                        if ($sender->hasPermission("repair.all.use")){
                            if (strtolower($args[0]) === "all"){
                                if (Main::getCooldown()->exists($sender->getXuid() . "-repair-all")){
                                    if (time() >= Main::getCooldown()->get($sender->getXuid() . "-repair-all")){
                                        $count = 0;
                                        foreach ($sender->getInventory()->getContents() as $slot => $item){
                                            if ($item instanceof Durable){
                                                $item->setDamage(0);
                                                $sender->getInventory()->setItem($slot, $item);
                                                $count++;
                                            }
                                        }
                                        foreach ($sender->getArmorInventory()->getContents() as $slot => $item){
                                            if ($item instanceof Durable){
                                                $item->setDamage(0);
                                                $sender->getArmorInventory()->setItem($slot, $item);
                                                $count++;
                                            }
                                        }
                                        $config = Main::getCooldown();
                                        $config->set($sender->getXuid() . "-repair-all", time() + $configYml->get("CooldownRepairAll"));
                                        $config->save();
                                        $sender->sendMessage($configYml->get("RepairAllMessage"));
                                        return;
                                    }else{
                                        $message = str_replace("{time}" , fonction::convert(Main::getCooldown()->get($sender->getXuid() . "-repair-all") - time()) . "." , $configYml->get("NoUseMessage"));
                                        $sender->sendMessage($message);
                                        return;
                                    }
                                }else{
                                    $count = 0;
                                    foreach ($sender->getInventory()->getContents() as $slot => $item){
                                        if ($item instanceof Durable){
                                            $item->setDamage(0);
                                            $sender->getInventory()->setItem($slot, $item);
                                            $count++;
                                        }
                                    }
                                    foreach ($sender->getArmorInventory()->getContents() as $slot => $item){
                                        if ($item instanceof Durable){
                                            $item->setDamage(0);
                                            $sender->getArmorInventory()->setItem($slot, $item);
                                            $count++;
                                        }
                                    }
                                    $config = Main::getCooldown();
                                    $config->set($sender->getXuid() . "-repair-all", time() + $configYml->get("CooldownRepairAll"));
                                    $config->save();
                                    $message = str_replace("{count}" , $count , $configYml->get("RepairAllMessage"));
                                    $sender->sendMessage($message);
                                    return;
                                }
                            }else{
                                $sender->sendMessage($configYml->get("UseInfo"));
                                return;
                            }
                        }else{
                            $sender->sendMessage($configYml->get("NoPerm"));
                            return;
                        }
                    }
                }else{
                    $sender->sendMessage($configYml->get("NoPerm"));
                    return;
                }
            }
        }
}
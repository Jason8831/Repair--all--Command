<?php

namespace Jason8831\Repair;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener
{
    public Config $config;
    private static Config $cooldown;
    /**
     * @var Main
     */
    private static $instance;

    public function onEnable(): void
    {
        self::$instance = $this;
        $this->getLogger()->info("§f[§l§4Repair§r§f]: activée");
        $this->saveResource("config.yml");
        if (!file_exists($this->getDataFolder() . "repair.json")){
            $this->saveResource("repair.json");
        }
        self::$cooldown = new Config($this->getDataFolder() . "repair.json", Config::JSON);

        $this->getServer()->getCommandMap()->registerAll("All", [
            new Commands\Repair(name: "repair", description: "permet de repair l'item qui est dans votre main", usageMessage: "reapir")
        ]);
    }

    public static function getInstance(): self{
        return self::$instance;
    }

    public static function getCooldown(): Config{
        return self::$cooldown;
    }
}
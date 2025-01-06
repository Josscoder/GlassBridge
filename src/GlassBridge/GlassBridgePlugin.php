<?php

namespace GlassBridge;

use CortexPE\Commando\exception\HookAlreadyRegistered;
use CortexPE\Commando\PacketHooker;
use GlassBridge\command\GlassBridgeCommand;
use GlassBridge\listener\GlassBridgeListener;
use GlassBridge\listener\GlassEditListener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat;

class GlassBridgePlugin extends PluginBase
{
    use SingletonTrait {
        setInstance as private;
        reset as private;
    }

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    /**
     * @throws HookAlreadyRegistered
     */
    protected function onEnable(): void
    {
        if (!PacketHooker::isRegistered()) {
            PacketHooker::register($this);
        }

        $pluginManager = $this->getServer()->getPluginManager();
        $pluginManager->registerEvents(new GlassBridgeListener(), $this);
        $pluginManager->registerEvents(new GlassEditListener(), $this);

        $this->getServer()->getCommandMap()->register('glassbridge', new GlassBridgeCommand($this, 'glassbridge'));

        $this->getLogger()->info(TextFormat::GREEN . 'SquidGame Glass Bridge plugin enabled');
    }

    protected function onDisable(): void
    {
        $this->getLogger()->info(TextFormat::RED . 'SquidGame Glass Bridge plugin disabled');
    }
}
<?php

namespace GlassBridge\command;

use CortexPE\Commando\BaseCommand;
use GlassBridge\command\subcommands\AddGlassSectionSubCommand;
use GlassBridge\command\subcommands\EditGlassSectionSubCommand;
use GlassBridge\command\subcommands\RemoveGlassSectionSubCommand;
use GlassBridge\GlassBridgePlugin;
use pocketmine\command\CommandSender;
use pocketmine\plugin\Plugin;

class GlassBridgeCommand extends BaseCommand
{
    /**
     * @var GlassBridgePlugin
     */
    protected Plugin $plugin;

    protected function prepare(): void
    {
        $this->registerSubCommand(new AddGlassSectionSubCommand($this->plugin,
            'add',
            'Adds a new section of glass'
        ));
        $this->registerSubCommand(new RemoveGlassSectionSubCommand($this->plugin,
            'remove',
            'Removes a section of glass'
        ));
        $this->registerSubCommand(new EditGlassSectionSubCommand($this->plugin,
            'edit',
            'Edit a section of glass'
        ));

        $this->setPermission('glassbridge.command');
    }

    /**
     * @param CommandSender $sender
     * @param string $aliasUsed
     * @param array<string, mixed> $args
     * @return void
     */
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void {}
}
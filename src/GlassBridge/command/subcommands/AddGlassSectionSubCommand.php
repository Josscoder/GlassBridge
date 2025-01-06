<?php

namespace GlassBridge\command\subcommands;

use CortexPE\Commando\args\IntegerArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\constraint\InGameRequiredConstraint;
use CortexPE\Commando\exception\ArgumentOrderException;
use GlassBridge\data\GlassBridge;
use GlassBridge\data\GlassSection;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class AddGlassSectionSubCommand extends BaseSubCommand
{
    /**
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new IntegerArgument('index'));
        $this->addConstraint(new InGameRequiredConstraint($this));
        $this->setUsage('/glassbridge add <index>');
    }

    /**
     * @param Player $sender
     * @param string $aliasUsed
     * @param array<string, mixed> $args
     * @return void
     */
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        /** @var int $index */
        $index = $args['index'];

        if (GlassBridge::getInstance()->exists($index)) {
            $sender->sendMessage(TextFormat::RED . 'That section of the glass bridge already exists!');

            return;
        }

        GlassBridge::getInstance()->addSection(new GlassSection($index, null, null));

        $sender->sendMessage(TextFormat::colorize("&aYou have created the glass bridge section &e#$index&a!"));
        $sender->sendMessage(TextFormat::colorize("&bNow use &6/glassbridge edit <index> &bto set the &6firstGlass &band the &6secondGlass"));
    }
}
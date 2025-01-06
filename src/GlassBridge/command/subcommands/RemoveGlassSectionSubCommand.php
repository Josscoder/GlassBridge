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

class RemoveGlassSectionSubCommand extends BaseSubCommand
{
    /**
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new IntegerArgument('index'));
        $this->addConstraint(new InGameRequiredConstraint($this));
        $this->setUsage('/glassbridge remove <index>');
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

        if (!GlassBridge::getInstance()->exists($index)) {
            $sender->sendMessage(TextFormat::RED . 'That section of the glass bridge does not exist!');

            return;
        }

        GlassBridge::getInstance()->removeSection($index);

        $sender->sendMessage(TextFormat::colorize("&aYou have removed the &e#$index &asection from the glass bridge!"));
    }
}
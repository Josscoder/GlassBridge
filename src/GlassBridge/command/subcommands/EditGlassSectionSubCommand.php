<?php

namespace GlassBridge\command\subcommands;

use CortexPE\Commando\args\IntegerArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\constraint\InGameRequiredConstraint;
use CortexPE\Commando\exception\ArgumentOrderException;
use GlassBridge\data\GlassBridge;
use GlassBridge\data\GlassSection;
use GlassBridge\registry\GlassEditManager;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class EditGlassSectionSubCommand extends BaseSubCommand
{
    /**
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new IntegerArgument('index'));
        $this->addConstraint(new InGameRequiredConstraint($this));
        $this->setUsage('/glassbridge edit <index>');
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

        if (is_null($glassSection = GlassBridge::getInstance()->getSection($index))) {
            $sender->sendMessage(TextFormat::RED . 'That section of the glass bridge does not exist!');

            return;
        }

        if (GlassEditManager::getInstance()->exists($sender)) {
            $sender->sendMessage(TextFormat::RED . 'You are already editing another glass section, finish editing to edit another one!');

            return;
        }

        $glassSection->setFirstGlass(null);
        $glassSection->setSecondGlass(null);

        GlassEditManager::getInstance()->addEditor($sender, $glassSection);
        $sender->sendMessage(TextFormat::colorize("&aYou are editing the glass section &e#$index&a!"));
        $sender->sendMessage(TextFormat::GOLD . "-> break the first glass's minVector");
    }
}
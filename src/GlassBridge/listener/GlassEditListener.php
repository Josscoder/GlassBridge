<?php

namespace GlassBridge\listener;

use GlassBridge\data\Glass;
use GlassBridge\data\GlassBridge;
use GlassBridge\registry\GlassEditManager;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;

class GlassEditListener implements Listener
{
    public function onBlockBreak(BlockBreakEvent $event): void
    {
        $player = $event->getPlayer();

        $glassEditManager = GlassEditManager::getInstance();

        if (is_null($glassSection = $glassEditManager->getGlassSection($player))) {
            return;
        }

        $event->cancel();

        $vector3 = $event->getBlock()->getPosition()->asVector3();

        if (is_null($firstGlass = $glassSection->getFirstGlass())) {
            $firstGlass = new Glass();
            $firstGlass->setMinVector($vector3);
            $glassSection->setFirstGlass($firstGlass);

            $player->sendMessage(TextFormat::GOLD . "-> break the first glass's maxVector");

            return;
        }

        if (is_null($firstGlass->getMaxVector())) {
            $firstGlass->setMaxVector($vector3);

            $player->sendMessage(TextFormat::GOLD . "-> break the second glass's minVector");

            return;
        }

        if (is_null($secondGlass = $glassSection->getSecondGlass())) {
            $secondGlass = new Glass();
            $secondGlass->setMinVector($vector3);
            $glassSection->setSecondGlass($secondGlass);

            $player->sendMessage(TextFormat::GOLD . "-> break the second glass's maxVector");

            return;
        }

        if (!is_null($secondGlass->getMaxVector())) {
            return;
        }

        $secondGlass->setMaxVector($vector3);

        if (!is_null($originalSection = GlassBridge::getInstance()->getSection($glassSection->getIndex()))) {
            $originalSection->setFirstGlass($firstGlass);
            $originalSection->setSecondGlass($secondGlass);
        }

        $glassEditManager->removeEditor($player);
        $player->sendMessage(TextFormat::GREEN . 'You just edited the glass section!');
    }
}
<?php

namespace GlassBridge\listener;

use GlassBridge\data\GlassBridge;
use pocketmine\block\VanillaBlocks;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\world\sound\BlockBreakSound;

class GlassBridgeListener implements Listener
{
    public function onMove(PlayerMoveEvent $event): void
    {
        $player = $event->getPlayer();

        if ($player->isSpectator()) {
            return;
        }

        $vector3 = $player->getLocation()->asVector3();
        $vector3Below = clone $vector3->subtract(0, 1, 0);

        if (is_null($glassSection = GlassBridge::getInstance()->getSectionByVector3($vector3Below)) ||
            is_null($glass = $glassSection->getGlassByVector3($vector3Below)) ||
            !$glass->isTempered() ||
            $glass->isBroken()
        ) {
            return;
        }

        $world = $player->getWorld();

        $glass->forEach(function (int $x, int $y, int $z) use ($world): void {
            $world->setBlockAt($x, $y, $z, VanillaBlocks::AIR());
        });

        $world->addSound($vector3, new BlockBreakSound(VanillaBlocks::GLASS()));
    }
}
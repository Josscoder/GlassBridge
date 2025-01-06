<?php

namespace GlassBridge\registry;

use GlassBridge\data\GlassSection;
use pocketmine\player\Player;
use pocketmine\utils\SingletonTrait;

class GlassEditManager
{
    use SingletonTrait {
        setInstance as private;
        reset as private;
    }

    /**
     * @var array<string, GlassSection>
     */
    private array $editors = [];

    public function addEditor(Player $player, GlassSection $section): void
    {
        $this->editors[$player->getName()] = $section;
    }

    public function getGlassSection(Player $player): ?GlassSection
    {
        return $this->editors[$player->getName()] ?? null;
    }

    public function exists(Player $player): bool
    {
        return !is_null($this->getGlassSection($player));
    }

    public function removeEditor(Player $player): void
    {
        unset($this->editors[$player->getName()]);
    }
}
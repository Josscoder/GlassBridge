<?php

namespace GlassBridge\data;

use pocketmine\math\Vector3;
use pocketmine\utils\SingletonTrait;

class GlassBridge
{
    use SingletonTrait {
        setInstance as private;
        reset as private;
    }

    /**
     * @var array<int, GlassSection>
     */
    private array $glassSections = [];

    public function addSection(GlassSection $section): void
    {
        $this->glassSections[$section->getIndex()] = $section;
    }

    public function getSection(int $index): ?GlassSection
    {
        return $this->glassSections[$index] ?? null;
    }

    public function getSectionByVector3(Vector3 $vector3): ?GlassSection
    {
        $matchSections = array_filter($this->glassSections, function (GlassSection $section) use ($vector3) {
            return !is_null($section->getGlassByVector3($vector3));
        });

        return $matchSections[array_key_first($matchSections)] ?? null;
    }

    public function exists(int $index): bool
    {
        return !is_null($this->getSection($index));
    }

    public function removeSection(int $index): void
    {
        unset($this->glassSections[$index]);
    }
}

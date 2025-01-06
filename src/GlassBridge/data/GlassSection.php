<?php

namespace GlassBridge\data;

use pocketmine\math\Vector3;

class GlassSection
{
    public function __construct(
        private readonly int $index,
        private ?Glass $firstGlass,
        private ?Glass $secondGlass
    ) {}

    public function getIndex(): int
    {
        return $this->index;
    }

    public function getFirstGlass(): ?Glass
    {
        return $this->firstGlass;
    }

    public function setFirstGlass(?Glass $firstGlass): void
    {
        $this->firstGlass = $firstGlass;

        $this->randomSelection();
    }

    public function getSecondGlass(): ?Glass
    {
        return $this->secondGlass;
    }

    public function setSecondGlass(?Glass $secondGlass): void
    {
        $this->secondGlass = $secondGlass;

        $this->randomSelection();
    }

    public function getGlassByVector3(Vector3 $vector3): ?Glass
    {
        if (!is_null($firstGlass = $this->getFirstGlass()) &&
            $firstGlass->isInside($vector3)
        ) {
            return $firstGlass;
        }

        if (!is_null($secondGlass = $this->getSecondGlass()) &&
            $secondGlass->isInside($vector3)
        ) {
            return $secondGlass;
        }

        return null;
    }

    public function randomSelection(): void
    {
        $tempered = rand(0, 1) === 1;

        if (!is_null($firstGlass = $this->firstGlass)) {
            $firstGlass->setTempered($tempered);
        }

        if (!is_null($secondGlass = $this->secondGlass)) {
            $secondGlass->setTempered(!$tempered);
        }
    }
}
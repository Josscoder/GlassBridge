<?php

namespace GlassBridge\data;

use Closure;
use pocketmine\math\Vector3;
use pocketmine\utils\Utils;

class Glass
{
    public function __construct(
        private ?Vector3 $minVector = null,
        private ?Vector3 $maxVector = null,
        private bool $tempered = true,
        private bool $broken = false
    ) {}

    public function getMinVector(): ?Vector3
    {
        return $this->minVector;
    }

    public function setMinVector(?Vector3 $minVector): void
    {
        $this->minVector = $minVector;
    }

    public function getMaxVector(): ?Vector3
    {
        return $this->maxVector;
    }

    public function setMaxVector(?Vector3 $maxVector): void
    {
        $this->maxVector = $maxVector;
    }

    public function isInside(Vector3 $vector3): bool
    {
        if (is_null($this->minVector) || is_null($this->maxVector)) {
            return false;
        }

        return (int) $this->minVector->getX() <= (int) $vector3->getX() &&
            (int) $this->maxVector->getX() >= (int) $vector3->getX() &&
            (int) $this->minVector->getZ() <= (int) $vector3->getZ() &&
            (int) $this->maxVector->getZ() >= (int) $vector3->getZ();
    }

    /**
     * @param Closure $closure
     * @return void
     */
    public function forEach(Closure $closure): void
    {
        Utils::validateCallableSignature(function (int $x, int $y, int $z): void {}, $closure);

        if (is_null($this->minVector) || is_null($this->maxVector)) {
            return;
        }

        /** @var int $minX */
        $minX = $this->minVector->getX();
        /** @var int $maxX */
        $maxX = $this->maxVector->getX();

        /** @var int $minY */
        $minY = $this->minVector->getY();
        /** @var int $maxY */
        $maxY = $this->maxVector->getY();

        /** @var int $minZ */
        $minZ = $this->minVector->getZ();
        /** @var int $maxZ */
        $maxZ = $this->maxVector->getZ();

        for ($x = $minX; $x <= $maxX; $x++) {
            for ($y = $minY; $y <= $maxY; $y++) {
                for ($z = $minZ; $z <= $maxZ; $z++) {
                    $closure($x, $y, $z);
                }
            }
        }
    }

    public function isTempered(): bool
    {
        return $this->tempered;
    }

    public function setTempered(bool $tempered = true): void
    {
        $this->tempered = $tempered;
    }

    public function isBroken(): bool
    {
        return $this->broken;
    }

    public function setBroken(bool $broken = true): void
    {
        $this->broken = $broken;
    }
}
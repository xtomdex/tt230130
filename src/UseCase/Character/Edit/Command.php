<?php

declare(strict_types=1);

namespace App\UseCase\Character\Edit;

use App\Entity\Character;

final class Command
{
    public function __construct(
        public int $id,
        public string $name,
        public int $height,
        public int $mass,
        public string $gender
    ) {}

    public static function fromCharacter(Character $character): self
    {
        return new self(
            $character->getId(),
            $character->getName(),
            $character->getHeight(),
            $character->getMass(),
            $character->getGender()
        );
    }
}

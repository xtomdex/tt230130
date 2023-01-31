<?php

declare(strict_types=1);

namespace App\UseCase\Character\Edit;

use App\Entity\Character;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

final class Command
{
    #[Assert\Image]
    public ?UploadedFile $image = null;

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

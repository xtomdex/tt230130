<?php

declare(strict_types=1);

namespace App\Event\Character;

final class CharacterDeletedEvent
{
    public function __construct(public readonly string $pictureFilename) {}
}

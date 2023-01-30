<?php

declare(strict_types=1);

namespace App\Service\DataImport;

final class CharacterView
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly int $height,
        public readonly int $mass,
        public readonly string $gender,
        public readonly array $movies
    ) {}
}

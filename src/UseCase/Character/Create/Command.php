<?php

declare(strict_types=1);

namespace App\UseCase\Character\Create;

final class Command
{
    public function __construct(
        public int $id,
        public string $name,
        public int $height,
        public int $mass,
        public string $gender,
        public array $movies
    ) {}
}

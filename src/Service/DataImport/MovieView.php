<?php

declare(strict_types=1);

namespace App\Service\DataImport;

final class MovieView
{
    public function __construct(
        public readonly int $id,
        public readonly string $name
    ) {}
}

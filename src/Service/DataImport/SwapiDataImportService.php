<?php

declare(strict_types=1);

namespace App\Service\DataImport;

final class SwapiDataImportService implements DataImportServiceInterface
{
    public function __construct(private readonly SwapiSDK $sdk) {}

    public function getCharacters(): array
    {

    }

    public function getMovies(): array
    {

    }
}

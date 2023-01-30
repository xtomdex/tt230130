<?php

declare(strict_types=1);

namespace App\Service\DataImport;

interface DataImportServiceInterface
{
    /**
     * @return array<CharacterView>
     */
    public function getCharacters(): array;
    /**
     * @return array<MovieView>
     */
    public function getMovies(): array;
}

<?php

declare(strict_types=1);

namespace App\Service\Swapi;

use App\Service\DataImport\CharacterView;
use App\Service\DataImport\DataImportServiceInterface;
use App\Service\DataImport\MovieView;

final class DataImportService implements DataImportServiceInterface
{
    public function __construct(private readonly ApiWrapper $api) {}

    public function getCharacters(): array
    {
        $characters = $this->api->getCharacters(30);

        return array_map(function ($character) {
            $id = IdParser::parseIdFromUrl($character['url']);
            $name = $character['name'];
            $height = (int) $character['height'];
            $mass = (int) $character['mass'];
            $gender = match ($character['gender']) {
                'male' => 'M',
                'female' => 'F',
                default => 'N/A'
            };
            $movies = [];
            foreach ($character['films'] as $film) {
                $movies[] = IdParser::parseIdFromUrl($film);
            }

            return new CharacterView($id, $name, $height, $mass, $gender, $movies);
        }, $characters);
    }

    public function getMovies(): array
    {
        $movies = $this->api->getMovies();

        return array_map(function ($movie) {
            $id = IdParser::parseIdFromUrl($movie['url']);
            return new MovieView($id, $movie['title']);
        }, $movies);
    }
}

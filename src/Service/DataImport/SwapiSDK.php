<?php

declare(strict_types=1);

namespace App\Service\DataImport;

use Symfony\Contracts\HttpClient\HttpClientInterface;

final class SwapiSDK
{
    private const BASE_URL = 'https://swapi.dev/api/';

    public function __construct(
        private readonly HttpClientInterface $client
    ) {}

    public function getMovies()
    {
        $response = $this->client->request(
            'GET',
            self::BASE_URL . 'films/'
        );

        return $response->toArray();
    }

}

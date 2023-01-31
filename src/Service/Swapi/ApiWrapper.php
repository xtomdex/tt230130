<?php

declare(strict_types=1);

namespace App\Service\Swapi;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class ApiWrapper
{
    private const BASE_URL = 'https://swapi.dev/api/';
    private const PER_PAGE = 10;

    public function __construct(
        private readonly HttpClientInterface $client
    ) {}

    public function getCharacters(int $limit = 10): array
    {
        $url = self::BASE_URL . 'people/';
        $response = $this->get($url);

        if ($limit > 10) {
            return $this->getInBulk($response, $limit);
        }

        return array_slice($response['results'], 0, $limit);
    }

    public function getMovies(): array
    {
        $url = self::BASE_URL . 'films/';
        $response = $this->get($url);

        return $response['results'];
    }

    private function get(string $url): array
    {
        $response = $this->client->request('GET', $url);

        return $this->normalizeResponse($response);
    }

    private function normalizeResponse(ResponseInterface $response): array
    {
        if (($statusCode = $response->getStatusCode()) !== 200) {
            throw new HttpException($statusCode, 'Failed to get data from Swapi');
        }

        return $response->toArray();
    }

    private function getInBulk(array $response, int $limit): array
    {
        $totalCount = $response['count'];
        $allCharacters = $response['results'];
        $limit = min($limit, $totalCount);
        $numberOfLoops = ceil($limit / self::PER_PAGE);
        $cnt = $limit - self::PER_PAGE;

        for ($i = 1; $i < $numberOfLoops; $i++) {
            if (($nextUrl = $response['next']) === null) {
                break;
            }

            $response = $this->get($nextUrl);

            $results = $response['results'];
            $cnt -= count($results);
            $characters = $cnt < 0 ? array_slice($results, 0, $cnt) : $results;

            $allCharacters = array_merge($allCharacters, $characters);
        }

        return $allCharacters;
    }
}

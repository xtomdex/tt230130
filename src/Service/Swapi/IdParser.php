<?php

declare(strict_types=1);

namespace App\Service\Swapi;

final class IdParser
{
    public static function parseIdFromUrl(string $url): int
    {
        $movieUrlParts = explode('/', $url);
        $lastPart = end($movieUrlParts);
        $id = prev($movieUrlParts);

        return (int) $id;
    }
}

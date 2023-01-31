<?php

declare(strict_types=1);

namespace App\Service\Filesystem;

use Symfony\Component\Filesystem\Filesystem;

final class FileRemover
{
    public function __construct(
        private readonly Filesystem $filesystem,
        private string $uploadsPath
    ) {}

    public function remove(string $fileName, string $directory = ''): void
    {
        $path = $this->uploadsPath . $directory . '/' . $fileName;
        $this->filesystem->remove($path);
    }
}

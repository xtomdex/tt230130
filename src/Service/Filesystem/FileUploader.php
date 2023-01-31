<?php

declare(strict_types=1);

namespace App\Service\Filesystem;

use Symfony\Component\HttpFoundation\File\UploadedFile;

final class FileUploader
{
    public function __construct(private string $uploadsPath) {}

    public function upload(UploadedFile $file, string $directory = ''): string
    {
        $destination = $this->uploadsPath . $directory;
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = md5($originalFilename).uniqid().'.'.$file->guessExtension();
        $file->move(
            $destination,
            $newFilename
        );

        return $newFilename;
    }
}

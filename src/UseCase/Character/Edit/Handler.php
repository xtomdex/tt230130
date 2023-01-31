<?php

declare(strict_types=1);

namespace App\UseCase\Character\Edit;

use App\Event\Character\PictureUpdatedEvent;
use App\Repository\CharacterRepository;
use App\Service\Filesystem\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class Handler
{
    public function __construct(
        private readonly CharacterRepository    $characters,
        private readonly FileUploader           $imageUploader,
        private readonly EntityManagerInterface $em,
        private readonly EventDispatcherInterface $dispatcher
    ) {}

    public function handle(Command $command): void
    {
        $character = $this->characters->get($command->id);

        $character->edit($command->name, $command->height, $command->mass, $command->gender);

        if ($command->image) {
            if ($oldPictureName = $character->getPictureName()) {
                $this->dispatcher->dispatch(new PictureUpdatedEvent($oldPictureName));
            }
            $newPictureName = $this->imageUploader->upload($command->image, '/characters');
            $character->setPictureName($newPictureName);
        }

        $this->em->flush();
    }
}

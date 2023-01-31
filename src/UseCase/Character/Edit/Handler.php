<?php

declare(strict_types=1);

namespace App\UseCase\Character\Edit;

use App\Repository\CharacterRepository;
use Doctrine\ORM\EntityManagerInterface;

final class Handler
{
    public function __construct(
        private readonly CharacterRepository $characters,
        private readonly EntityManagerInterface $em
    ) {}

    public function handle(Command $command): void
    {
        $character = $this->characters->get($command->id);

        $character->edit($command->name, $command->height, $command->mass, $command->gender);

        $this->em->flush();
    }
}

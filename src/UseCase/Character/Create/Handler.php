<?php

declare(strict_types=1);

namespace App\UseCase\Character\Create;

use App\Entity\Character;
use App\Exception\CharacterAlreadyExists;
use App\Repository\CharacterRepository;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;

final class Handler
{
    public function __construct(
        private readonly CharacterRepository $characters,
        private readonly MovieRepository $movies,
        private readonly EntityManagerInterface $em
    ) {}

    public function handle(Command $command): void
    {
        if ($this->characters->find($command->id)) {
            throw new CharacterAlreadyExists(sprintf('Character with ID "%d" already exists', $command->id));
        }

        $character = Character::create($command->id, $command->name, $command->height, $command->mass, $command->gender);
        $this->em->persist($character);

        $charactersMovies = $this->movies->findBy(['id' => $command->movies]);
        foreach ($charactersMovies as $charactersMovie) {
            $character->addMovie($charactersMovie);
        }

        $this->em->flush();
    }
}

<?php

declare(strict_types=1);

namespace App\UseCase\Movie\Create;

use App\Entity\Movie;
use App\Exception\MovieAlreadyExists;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;

final class Handler
{
    public function __construct(
        private readonly MovieRepository $movies,
        private readonly EntityManagerInterface $em
    ) {}

    public function handle(Command $command): void
    {
        if ($this->movies->find($command->id)) {
            throw new MovieAlreadyExists(sprintf('Movie with ID "%d" already exists', $command->id));
        }

        $movie = Movie::create($command->id, $command->name);
        $this->em->persist($movie);
        $this->em->flush();
    }
}

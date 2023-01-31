<?php

declare(strict_types=1);

namespace App\UseCase\Character\Delete;

use App\Entity\Character;
use App\Event\Character\CharacterDeletedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class Handler
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly EventDispatcherInterface $dispatcher
    ) {}

    public function handle(Character $character): void
    {
        $this->dispatcher->dispatch(new CharacterDeletedEvent($character->getPictureName()));
        $this->em->remove($character);
        $this->em->flush();
    }
}

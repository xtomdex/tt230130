<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Character;
use App\Exception\CharacterNotFound;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class CharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Character::class);
    }

    public function get(int $id): Character
    {
        if (!($character = $this->find($id))) {
            throw new CharacterNotFound();
        }

        return $character;
    }

    public function findByName(string $name): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.name LIKE :name')
            ->setParameter('name', '%' . addcslashes($name, '%_') . '%')
            ->getQuery()
            ->getResult();
    }
}

<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Character;
use App\Exception\CharacterNotFound;
use App\UseCase\Character\Index\Filter;
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

    public function findWithFilter(Filter $filter): array
    {
        $query = $this->createQueryBuilder('c');

        if ($filter->name && strlen($filter->name) > 2) {
            $query
                ->andWhere('c.name LIKE :name')
                ->setParameter('name', '%' . addcslashes($filter->name, '%_') . '%')
            ;
        }


        return $query->getQuery()->getResult();
    }
}

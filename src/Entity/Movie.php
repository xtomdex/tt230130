<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CharacterRepository;
use Doctrine\ORM\Mapping\GeneratedValue;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\Table(name: "movies")]
final class Movie
{
    #[ORM\Id]
    #[GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string")]
    private string $name;

    private function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public static function create(int $id, string $name): self
    {
        return new self($id, $name);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

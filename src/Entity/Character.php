<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CharacterRepository;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\InverseJoinColumn;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\Table(name: "characters")]
final class Character
{
    #[ORM\Id]
    #[GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string")]
    private string $name;

    #[ORM\Column(type: "integer")]
    private int $height;

    #[ORM\Column(type: "integer")]
    private int $mass;

    #[ORM\Column(type: "string", length: 3)]
    private string $gender;

    #[JoinTable(name: 'movies_characters')]
    #[JoinColumn(name: 'character_id', referencedColumnName: 'id')]
    #[InverseJoinColumn(name: 'movie_id', referencedColumnName: 'id')]
    #[ManyToMany(targetEntity: Movie::class)]
    private Collection $movies;

    #[ORM\Column(type: "string", nullable: true)]
    private ?string $picture;

    private function __construct(int $id, string $name, int $height, int $mass, string $gender)
    {
        $this->id = $id;
        $this->name = $name;
        $this->height = $height;
        $this->mass = $mass;
        $this->gender = $gender;
        $this->movies = new ArrayCollection();
    }

    public static function create(int $id, string $name, int $height, int $mass, string $gender): self
    {
        return new self($id, $name, $height, $mass, $gender);
    }

    public function edit(string $name, int $height, int $mass, string $gender): void
    {
        $this->name = $name;
        $this->height = $height;
        $this->mass = $mass;
        $this->gender = $gender;
    }

    public function updatePicture(?string $picture): void
    {
        $this->picture = $picture;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getMass(): int
    {
        return $this->mass;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function getMovies(): array
    {
        return $this->movies->toArray();
    }

    public function addMovie(Movie $movie): self
    {
        if (!$this->movies->contains($movie)) {
            $this->movies->add($movie);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): self
    {
        if ($this->movies->contains($movie)) {
            $this->movies->removeElement($movie);
        }

        return $this;
    }
}

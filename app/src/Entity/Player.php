<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
#[ORM\Table(name: "players")]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(length: 20)]
    private string $name;

    #[ORM\Column(length: 40)]
    private string $surname;

    #[ORM\Column(type: Types::SMALLINT)]
    private int $age;

    #[ORM\Column(length: 30)]
    private string $country;

	#[ORM\Column]
	private \DateTimeImmutable $createdAt;

	public function __construct(
		string $name,
		string $surname,
		int $age,
		string $country,
		\DateTimeImmutable $createdAt = new \DateTimeImmutable()
	) {
		$this->name = $name;
		$this->surname = $surname;
		$this->age = $age;
		$this->country = $country;
		$this->createdAt = $createdAt;
	}

	public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

	public function getCreatedAt(): \DateTimeImmutable
	{
		return $this->createdAt;
	}

	public function setCreatedAt(\DateTimeImmutable $createdAt): void
	{
		$this->createdAt = $createdAt;
	}
}

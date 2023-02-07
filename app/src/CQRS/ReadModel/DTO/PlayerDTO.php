<?php

declare(strict_types=1);

namespace App\CQRS\ReadModel\DTO;

use App\Entity\Player;

final class PlayerDTO
{
	public function __construct(
		public readonly int $id,
		public readonly string $name,
		public readonly string $surname,
		public readonly int $age,
		public readonly string $country,
		public readonly \DateTimeImmutable $createdAt
	) {
	}

	public static function fromEntity(Player $player): self
	{
		return new self(
			$player->getId(),
			$player->getName(),
			$player->getSurname(),
			$player->getAge(),
			$player->getCountry(),
			$player->getCreatedAt(),
		);
	}
}
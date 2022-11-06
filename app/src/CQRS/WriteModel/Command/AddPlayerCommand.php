<?php

declare(strict_types=1);

namespace App\CQRS\WriteModel\Command;

use Symfony\Component\Uid\Uuid;

final class AddPlayerCommand
{
	public function __construct(
		public readonly Uuid $id,
		public readonly string $name,
		public readonly string $surname,
		public readonly int $age,
		public readonly string $country,
	) {}
}
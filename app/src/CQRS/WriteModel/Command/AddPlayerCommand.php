<?php

declare(strict_types=1);

namespace App\CQRS\WriteModel\Command;


final class AddPlayerCommand
{
	public function __construct(
		public readonly string $name,
		public readonly string $surname,
		public readonly int $age,
		public readonly string $country,
	) {}
}
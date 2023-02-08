<?php

declare(strict_types=1);

namespace App\CQRS\WriteModel\Command;


final class DeletePlayerCommand
{
	public function __construct(
		public readonly int $id,
	) {}
}
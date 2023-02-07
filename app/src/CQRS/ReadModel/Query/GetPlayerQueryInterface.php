<?php

declare(strict_types=1);

namespace App\CQRS\ReadModel\Query;

use App\CQRS\ReadModel\DTO\PlayerDTO;

interface GetPlayerQueryInterface
{
	public function execute(int $id): ?PlayerDTO;
}
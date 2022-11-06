<?php

declare(strict_types=1);

namespace App\CQRS\ReadModel\Query;

use App\CQRS\ReadModel\DTO\PlayerDTO;
use Symfony\Component\Uid\Uuid;

interface GetPlayerQueryInterface
{
	public function execute(Uuid $id): ?PlayerDTO;
}
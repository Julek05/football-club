<?php

namespace App\Repository;

use App\Entity\Player;

interface PlayerRepositoryInterface
{
	public function findOneById(int $id): ?Player;

	public function save(Player $entity): void;

	public function remove(Player $entity): void;
}
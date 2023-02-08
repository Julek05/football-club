<?php

declare(strict_types=1);

namespace App\CQRS\WriteModel\Handler;

use App\CQRS\WriteModel\Command\AddPlayerCommand;
use App\Entity\Player;
use App\Repository\PlayerRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class AddPlayerHandler
{
	public function __construct(private readonly PlayerRepositoryInterface $playerRepository)
	{
	}

	public function __invoke(AddPlayerCommand $command): void
	{
		$player = new Player(
			$command->name,
			$command->surname,
			$command->age,
			$command->country,
		);

		$this->playerRepository->save($player);
	}
}
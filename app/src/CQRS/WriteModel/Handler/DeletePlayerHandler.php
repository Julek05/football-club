<?php

declare(strict_types=1);

namespace App\CQRS\WriteModel\Handler;

use App\CQRS\WriteModel\Command\DeletePlayerCommand;
use App\CQRS\WriteModel\Exception\NotFoundPlayerException;
use App\Repository\PlayerRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class DeletePlayerHandler
{
	public function __construct(
		private readonly PlayerRepositoryInterface $playerRepository
	) {
	}

	public function __invoke(DeletePlayerCommand $command): void
	{
		$player = $this->playerRepository->findOneById($command->id);

		if ($player === null) {
			throw new NotFoundPlayerException();
		}

		$this->playerRepository->remove($player);
	}
}
<?php

declare(strict_types=1);

namespace App\Query;

use App\CQRS\ReadModel\DTO\PlayerDTO;
use App\CQRS\ReadModel\Query\GetPlayerQueryInterface;
use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;

final class GetPlayerQuery implements GetPlayerQueryInterface
{
	public function __construct(private readonly EntityManagerInterface $entityManager)
	{
	}

	/**
	 * @throws NonUniqueResultException
	 */
	public function execute(int $id): ?PlayerDTO
	{
		$queryBuilder = $this->entityManager->createQueryBuilder();

		$result = $queryBuilder
			->select('p')
			->from(Player::class, 'p')
			->where($queryBuilder->expr()->eq('p.id', ':id'))
			->setParameter('id', $id)
			->getQuery()
			->getOneOrNullResult();

		if ($result === null) {
			return null;
		}

		return PlayerDTO::fromEntity($result);
	}
}
<?php

namespace App\Repository;

use App\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

class PlayerRepository extends ServiceEntityRepository implements PlayerRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }

	/**
	 * @throws NonUniqueResultException
	 */
	public function findOneById(int $id): ?Player
	{
		return $this->createQueryBuilder('p')
			->where('p.id = :id')
			->setParameter('id', $id, Types::INTEGER)
			->getQuery()
			->getOneOrNullResult();
	}

	public function save(Player $entity): void
    {
        $this->_em->persist($entity);

        $this->_em->flush();
    }

	public function remove(Player $entity): void
    {
        $this->_em->remove($entity);

        $this->_em->flush();
    }
}

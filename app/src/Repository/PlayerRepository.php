<?php

namespace App\Repository;

use App\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
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

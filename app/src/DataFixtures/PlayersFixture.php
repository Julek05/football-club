<?php

namespace DataFixtures;

use App\Entity\Player;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PlayersFixture extends Fixture
{
	public function load(ObjectManager $manager): void
	{
		$creationDate = new \DateTimeImmutable('2023-02-08 12:00:00');

		$player1 = new Player('Eden', 'Hazard', '32', 'Belarus', $creationDate);

		$manager->persist($player1);

		$player2 = new Player('Leo', 'Messi', '35', 'Argentina', $creationDate);

		$manager->persist($player2);

		$player3 = new Player('Karim', 'Benzema', '35', 'France', $creationDate);

		$manager->persist($player3);

		$manager->flush();
	}
}

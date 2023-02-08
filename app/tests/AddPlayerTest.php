<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\Player;
use Symfony\Component\HttpFoundation\Response;

class AddPlayerTest extends AbstractApiTestCase
{
	protected bool $runFixtures = false;

	public function testAddPlayer(): void
    {
		$payload = [
		    "name" => "Cristiano",
		    "surname" => "Ronaldo",
		    "age" => 33,
		    "country" => "Portugal"
		];
        $this->client->jsonRequest('POST', '/player', $payload);

	    $this->assertSame(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());

		$playerArrayValues = $this->getContainer()
		    ->get('doctrine.orm.entity_manager')
		    ->createQueryBuilder()
		    ->select(['p.name', 'p.surname', 'p.age', 'p.country'])
		    ->from(Player::class, 'p')
			->where('p.id = 1')
		    ->getQuery()
		    ->getArrayResult()[0];

		$this->assertSame($payload, $playerArrayValues);
    }
}

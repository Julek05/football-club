<?php

declare(strict_types=1);

namespace App\Tests;


use App\Entity\Player;
use Symfony\Component\HttpFoundation\Response;

class DeletePlayerTest extends AbstractApiTestCase
{
	protected bool $runFixtures = true;

    public function testNotFoundPlayer(): void
    {
	    $this->client->jsonRequest('DELETE', 'player/4');

		$this->assertSame(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
		$this->assertSame(
			json_encode(['message' => Response::$statusTexts[Response::HTTP_NOT_FOUND]]),
			$this->client->getResponse()->getContent()
		);
    }

	public function testDeletePlayer(): void
	{
		$this->client->jsonRequest('DELETE', 'player/1');

		$this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
		$this->assertSame(
			json_encode(['message' => Response::$statusTexts[Response::HTTP_OK]]),
			$this->client->getResponse()->getContent()
		);

		$player = $this->getContainer()
			->get('doctrine.orm.entity_manager')
			->createQueryBuilder()
			->select('p')
			->from(Player::class, 'p')
			->where('p.id = 1')
			->getQuery()
			->getOneOrNullResult();

		$this->assertSame(null, $player);
	}
}

<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Component\HttpFoundation\Response;

class GetPlayerTest extends AbstractApiTestCase
{
	protected bool $runFixtures = true;

	public function testNotFoundPlayer(): void
	{
		$this->client->jsonRequest('GET', 'player/7');

		$this->assertSame(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
		$this->assertSame(
			json_encode(['message' => Response::$statusTexts[Response::HTTP_NOT_FOUND]]),
			$this->client->getResponse()->getContent()
		);
	}

	public function testGetPlayer(): void
	{
		$this->client->jsonRequest('GET', 'player/2');

		$expectedResponse = json_encode([
			'message' => Response::$statusTexts[Response::HTTP_OK],
			'content' => [
				"id" => 2,
				"name" => "Leo",
				"surname" => "Messi",
				"age" => 35,
				"country" => "Argentina",
				"createdAt" => new \DateTimeImmutable('2023-02-08 12:00:00')
			]
		]);

		$this->assertSame($expectedResponse, $this->client->getResponse()->getContent());

		$this->assertSame(true, true);
	}
}

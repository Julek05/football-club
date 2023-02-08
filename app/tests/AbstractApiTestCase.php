<?php

declare(strict_types=1);

namespace App\Tests;

use DataFixtures\PlayersFixture;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractApiTestCase extends WebTestCase
{
	protected KernelBrowser $client;

	public function setUp(): void
	{
		$this->client = static::createClient();

		$entityManager = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');

		$metadata = $entityManager->getMetadataFactory()->getAllMetadata();
		$schemaTool = new SchemaTool($entityManager);
		$schemaTool->updateSchema($metadata);

		if (isset($this->runFixtures) && $this->runFixtures) {
			/** @var PlayersFixture $playersFixture */
			$playersFixture = self::$kernel->getContainer()->get(PlayersFixture::class);
			$playersFixture->load($entityManager);
		}
	}
}
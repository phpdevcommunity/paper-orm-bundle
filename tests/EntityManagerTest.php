<?php

namespace Test\PhpDevCommunity\PaperORMBundle;

use PhpDevCommunity\PaperORM\EntityManager;
use PhpDevCommunity\PaperORM\PaperConfiguration;
use PHPUnit\Framework\TestCase;

class EntityManagerTest extends TestCase
{

    public function testFromDsnCreatesConnection(): void
    {
        $em = EntityManager::createFromConfig(PaperConfiguration::fromDsn('sqlite://:memory:'));
        $this->assertInstanceOf(EntityManager::class, $em);
    }

}

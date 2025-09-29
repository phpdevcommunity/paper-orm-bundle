<?php

namespace Test\PhpDevCommunity\PaperORMBundle;

use PhpDevCommunity\PaperORM\EntityManager;
use PHPUnit\Framework\TestCase;

class EntityManagerTest extends TestCase
{

    public function testFromDsnCreatesConnection(): void
    {
        $em = EntityManager::createFromDsn('sqlite:///:memory:');
        $this->assertInstanceOf(EntityManager::class, $em);
    }

}

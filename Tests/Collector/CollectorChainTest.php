<?php

namespace Lexik\Bundle\DataLayerBundle\Tests\Collector;

use Lexik\Bundle\DataLayerBundle\Collector\CollectorChain;
use Lexik\Bundle\DataLayerBundle\Collector\CollectorInterface;
use Lexik\Bundle\DataLayerBundle\Collector\UserIdCollector;
use PHPUnit\Framework\TestCase;

/**
 * CollectorChainTest
 */
class CollectorChainTest extends TestCase
{
    /**
     * test default object
     */
    public function testNoCollectors()
    {
        $chain = new CollectorChain();

        $this->assertIsArray($chain->getCollectors());
        $this->assertCount(0, $chain->getCollectors());
    }

    /**
     * test not default object
     */
    public function testWithCollectors()
    {
        $chain = new CollectorChain();

        $chain->addCollector($this->createMock(UserIdCollector::class));
        $this->assertIsArray($chain->getCollectors());
        $this->assertCount(1, $chain->getCollectors());

        $chain->addCollector($this->createMock(CollectorInterface::class));
        $this->assertIsArray($chain->getCollectors());
        $this->assertCount(2, $chain->getCollectors());
    }
}

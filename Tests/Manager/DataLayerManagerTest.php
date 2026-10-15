<?php

namespace Lexik\Bundle\DataLayerBundle\Tests\Manager;

use Lexik\Bundle\DataLayerBundle\Collector\CollectorChain;
use Lexik\Bundle\DataLayerBundle\Collector\CollectorInterface;
use Lexik\Bundle\DataLayerBundle\Collector\UserIdCollector;
use Lexik\Bundle\DataLayerBundle\Manager\DataLayerManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

/**
 * DataLayerManagerTest
 */
class DataLayerManagerTest extends TestCase
{
    /**
     * test get method
     */
    public function testGet()
    {
        $manager = new DataLayerManager($this->getRequestStack(), new CollectorChain());

        $this->assertEquals([], $manager->all());
    }

    /**
     * test add method
     */
    public function testAdd()
    {
        $manager = new DataLayerManager($this->getRequestStack(), new CollectorChain());
        $manager->add(['goal' => true]);

        $this->assertEquals([['goal' => true]], $manager->all());
    }

    /**
     * test reset method
     */
    public function testReset()
    {
        $manager = new DataLayerManager($this->getRequestStack(), new CollectorChain());
        $manager->add(['goal' => true]);
        $manager->reset();

        $this->assertEquals([], $manager->all());
    }

    /**
     * test collectors are called
     */
    public function testCollectorChainUsage()
    {
        $manager = new DataLayerManager($this->getRequestStack(), $this->getCollectorChainMock());

        $this->assertEquals([], $manager->all());
    }

    /**
     * @return RequestStack
     */
    private function getRequestStack()
    {
        $request = new Request();
        $request->setSession(new Session(new MockArraySessionStorage()));

        $requestStack = new RequestStack();
        $requestStack->push($request);

        return $requestStack;
    }

    /**
     * @return CollectorChain
     */
    private function getCollectorChainMock()
    {
        $collectorChainMock = $this->createMock(CollectorChain::class);
        $collectorChainMock
            ->expects($this->once())
            ->method('getCollectors')
            ->willReturn([$this->getCollectorMock()]);

        return $collectorChainMock;
    }

    /**
     * @return CollectorInterface
     */
    private function getCollectorMock()
    {
        $collectorMock = $this->createMock(UserIdCollector::class);
        $collectorMock
            ->expects($this->once())
            ->method('handle');

        return $collectorMock;
    }
}

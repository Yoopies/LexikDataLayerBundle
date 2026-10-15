<?php

namespace Lexik\Bundle\DataLayerBundle\Tests\Twig\Extension;

use Lexik\Bundle\DataLayerBundle\Manager\DataLayerManager;
use Lexik\Bundle\DataLayerBundle\Twig\Extension\DataLayerExtension;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * DataLayerExtensionTest
 */
class DataLayerExtensionTest extends TestCase
{
    /**
     * test main twig function
     */
    public function testGetDataLayer()
    {
        $extension = new DataLayerExtension($this->getManagerMock());
        $this->assertEquals(json_encode([]), $extension->getDataLayer());
    }

    /**
     * @return MockObject|DataLayerManager
     */
    private function getManagerMock()
    {
        $managerMock = $this->createMock(DataLayerManager::class);
        $managerMock
            ->expects($this->once())
            ->method('all')
            ->willReturn([]);
        $managerMock
            ->expects($this->once())
            ->method('reset');

        return $managerMock;
    }
}

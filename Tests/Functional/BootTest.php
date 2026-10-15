<?php

namespace Lexik\Bundle\DataLayerBundle\Tests\Functional;

use Lexik\Bundle\DataLayerBundle\Manager\DataLayerManager;

/**
 * BootTest
 *
 * @see https://github.com/FriendsOfSymfony/FOSRestBundle/tree/master/Tests/Functional
 */
class BootTest extends TestCase
{
    public function testBoot()
    {
        $kernel = $this->createKernel();
        $kernel->boot();

        $this->assertSame('test', $kernel->getEnvironment());
        $this->assertTrue($kernel->isDebug());
        $this->assertInstanceOf(
            DataLayerManager::class,
            $kernel->getContainer()->get('lexik_data_layer.manager.data_layer_manager')
        );
    }
}

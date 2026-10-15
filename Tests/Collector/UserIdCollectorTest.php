<?php

namespace Lexik\Bundle\DataLayerBundle\Tests\Collector;

use Lexik\Bundle\DataLayerBundle\Collector\UserIdCollector;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\InMemoryUser;

/**
 * UserIdCollectorTest
 */
class UserIdCollectorTest extends TestCase
{
    /**
     * test handle method works
     */
    public function testImplementation()
    {
        $data = [];

        $collector = new UserIdCollector($this->getTokenStorage());
        $collector->handle($data);

        $this->assertIsArray($data[0]);
        $this->assertArrayHasKey('user_id', $data[0]);
        $this->assertEquals(md5('user'), $data[0]['user_id']);
    }

    /**
     * test nothing is collected without token
     */
    public function testWithoutToken()
    {
        $data = [];

        $collector = new UserIdCollector(new TokenStorage());
        $collector->handle($data);

        $this->assertSame([], $data);
    }

    /**
     * @return TokenStorageInterface
     */
    private function getTokenStorage()
    {
        $tokenMock = $this->createMock(TokenInterface::class);
        $tokenMock
            ->method('getUser')
            ->willReturn(new InMemoryUser('user', null));

        $tokenStorage = new TokenStorage();
        $tokenStorage->setToken($tokenMock);

        return $tokenStorage;
    }
}

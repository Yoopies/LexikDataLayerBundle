<?php

namespace Lexik\Bundle\DataLayerBundle\Collector;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * UserIdCollector
 */
class UserIdCollector implements CollectorInterface
{
    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(&$data)
    {
        $token = $this->tokenStorage->getToken();

        if (!$token || !$token->getUser() instanceof UserInterface) {
            return;
        }

        $user = $token->getUser();

        // getUserIdentifier() is only declared on UserInterface since Symfony 6.0
        $identifier = method_exists($user, 'getUserIdentifier') ? $user->getUserIdentifier() : $user->getUsername();

        $data[] = ['user_id' => md5($identifier)];
    }
}

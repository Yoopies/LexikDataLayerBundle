<?php

namespace Lexik\Bundle\DataLayerBundle\Tests\Functional;

use Composer\InstalledVersions;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;

/**
 * AppKernel
 */
class AppKernel extends Kernel
{
    /**
     * {@inheritdoc}
     */
    public function registerBundles(): iterable
    {
        return [
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new \Symfony\Bundle\TwigBundle\TwigBundle(),
            new \Lexik\Bundle\DataLayerBundle\LexikDataLayerBundle(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getProjectDir(): string
    {
        return __DIR__;
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir(): string
    {
        return sys_get_temp_dir().'/LexikDataLayerBundle/cache';
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir(): string
    {
        return sys_get_temp_dir().'/LexikDataLayerBundle/logs';
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__.'/config/config.yml');

        // The authenticator manager is opt-in on Symfony 5.4 and always enabled on 6.x
        if (version_compare(InstalledVersions::getVersion('symfony/security-bundle'), '6.0', '<')) {
            $loader->load(function (ContainerBuilder $container) {
                $container->loadFromExtension('security', ['enable_authenticator_manager' => true]);
            });
        }
    }
}

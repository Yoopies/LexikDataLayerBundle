<?php

namespace Lexik\Bundle\DataLayerBundle;

use Lexik\Bundle\DataLayerBundle\DependencyInjection\CompilerPass\CollectorCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * LexikDataLayerBundle
 */
class LexikDataLayerBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new CollectorCompilerPass());
    }
}

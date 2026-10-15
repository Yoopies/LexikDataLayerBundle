<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Lexik\Bundle\DataLayerBundle\Collector\CollectorChain;
use Lexik\Bundle\DataLayerBundle\Collector\UserIdCollector;
use Lexik\Bundle\DataLayerBundle\Manager\DataLayerManager;
use Lexik\Bundle\DataLayerBundle\Twig\Extension\DataLayerExtension;

return static function (ContainerConfigurator $container) {
    $container->parameters()
        ->set('lexik_data_layer.collector.collector_chain.class', CollectorChain::class)
        ->set('lexik_data_layer.collector.user_id.class', UserIdCollector::class)
        ->set('lexik_data_layer.manager.data_layer_manager.class', DataLayerManager::class)
        ->set('lexik_data_layer.twig.extension.class', DataLayerExtension::class);

    $container->services()
        // COLLECTOR CHAIN
        ->set('lexik_data_layer.collector.collector_chain', '%lexik_data_layer.collector.collector_chain.class%')
            ->public()
        ->alias(CollectorChain::class, 'lexik_data_layer.collector.collector_chain')

        // USER ID COLLECTOR
        ->set('lexik_data_layer.collector.user_id', '%lexik_data_layer.collector.user_id.class%')
            ->args([service('security.token_storage')])
            ->tag('lexik_data_layer.collector')

        // MANAGER
        ->set('lexik_data_layer.manager.data_layer_manager', '%lexik_data_layer.manager.data_layer_manager.class%')
            ->public()
            ->args([
                service('request_stack'),
                service('lexik_data_layer.collector.collector_chain'),
            ])
        ->alias(DataLayerManager::class, 'lexik_data_layer.manager.data_layer_manager')

        // TWIG
        ->set('lexik_data_layer.twig.extension', '%lexik_data_layer.twig.extension.class%')
            ->args([service('lexik_data_layer.manager.data_layer_manager')])
            ->tag('twig.extension');
};

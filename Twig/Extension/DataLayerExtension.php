<?php

namespace Lexik\Bundle\DataLayerBundle\Twig\Extension;

use Lexik\Bundle\DataLayerBundle\Manager\DataLayerManager;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * DataLayerExtension
 */
class DataLayerExtension extends AbstractExtension
{
    /**
     * @var DataLayerManager
     */
    protected $dataLayerManager;

    /**
     * @param DataLayerManager $manager
     */
    public function __construct(DataLayerManager $manager)
    {
        $this->dataLayerManager = $manager;
    }

    /**
     * @return string JSON encoded data layer
     */
    public function getDataLayer()
    {
        $data = $this->dataLayerManager->all();
        $this->dataLayerManager->reset();

        return json_encode($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('lexik_data_layer', [$this, 'getDataLayer'], ['is_safe' => ['html']]),
        ];
    }
}

<?php

namespace Lexik\Bundle\DataLayerBundle\Manager;

use Lexik\Bundle\DataLayerBundle\Collector\CollectorChain;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * DataLayerManager
 */
class DataLayerManager
{
    const KEY = 'lexik_data_layer';

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var CollectorChain
     */
    protected $collectorChain;

    /**
     * @param RequestStack   $requestStack
     * @param CollectorChain $collectorChain
     */
    public function __construct(RequestStack $requestStack, CollectorChain $collectorChain)
    {
        $this->requestStack = $requestStack;
        $this->collectorChain = $collectorChain;
    }

    /**
     * Add data to the data layer.
     *
     * @param array $data ['data_name' => 'data_value']
     */
    public function add(array $data)
    {
        $session = $this->getSession();
        $current = $session->get(self::KEY, []);
        $current[] = $data;

        $session->set(self::KEY, $current);
    }

    /**
     * Get data layer data.
     *
     * @return array [['data_name' => 'data_value']]
     */
    public function all()
    {
        $data = $this->getSession()->get(self::KEY, []);

        foreach ($this->collectorChain->getCollectors() as $collector) {
            $collector->handle($data);
        }

        return $data;
    }

    /**
     * Reset data layer value.
     */
    public function reset()
    {
        $this->getSession()->remove(self::KEY);
    }

    /**
     * @return SessionInterface
     */
    protected function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }
}

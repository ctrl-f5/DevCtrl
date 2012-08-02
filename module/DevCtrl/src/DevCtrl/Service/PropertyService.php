<?php

namespace DevCtrl\Service;

use DevCtrl\Domain\Item\Property\Property;

class PropertyService extends \Ctrl\Service\AbstractDomainEntityService
{
    protected $entity = 'DevCtrl\Domain\Item\Property\Property';

    public function getConfiguredDefaultValueProviders()
    {
        $config = $this->getServiceLocator()->get('Configuration');
        $k = \DevCtrl\Module::ITEM_PROP_DEFAULT_PROVIDERS;
        if (isset($config[$k])) {
            $providers = array();
            foreach ($config[$k] as $k => $v) {
                $providers[$k] = $this->getServiceLocator()
                    ->get('DefaultProviderLoader')
                    ->get($k);
            }
            return $providers;
        }
        return array();
    }

    /**
     * @param $providerName
     * @return \DevCtrl\Domain\Item\Property\DefaultProvider\ProviderInterface
     */
    public function getConfiguredDefaultValueProvider($providerName)
    {
        return $this->getServiceLocator()
            ->get('DefaultProviderLoader')
            ->get($providerName);
    }

    public function getConfiguredValuesProviders()
    {
        $config = $this->getServiceLocator()->get('Configuration');
        $k = \DevCtrl\Module::ITEM_PROP_VALUES_PROVIDERS;
        if (isset($config[$k])) {
            $providers = array();
            foreach ($config[$k] as $k => $v) {
                $providers[$k] = $this->getServiceLocator()
                    ->get('ValuesProviderLoader')
                    ->get($k);
            }
            return $providers;
        }
        return array();
    }
}

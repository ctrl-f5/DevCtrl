<?php

namespace DevCtrl\Service;

use \DevCtrl\Domain;

class ItemPropertyService extends \Ctrl\Service\AbstractDomainEntityService
{
    protected $entity = 'DevCtrl\Domain\Item\Property';

    public function getAllConfiguredDefaultValueProviders()
    {
        $config = $this->getServiceLocator()->get('Configuration');
        $k = \DevCtrl\Module::ITEM_PROP_DEFAULT_VALUE_PROVIDERS;
        if (isset($config[$k])) {
            return array_keys($config[$k]);
        }
        return array();
    }

    public function getAllConfiguredPossibleValuesProviders()
    {
        $config = $this->getServiceLocator()->get('Configuration');
        $k = \DevCtrl\Module::ITEM_PROP_POSSIBLE_VALUES_PROVIDERS;
        if (isset($config[$k])) {
            return array_keys($config[$k]);
        }
        return array();
    }
}

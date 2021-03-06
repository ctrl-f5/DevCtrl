<?php

namespace DevCtrl\Domain\Item\Property\ValuesProvider;

use DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\Type\Type;
use DevCtrl\Domain\Exception;

abstract class AbstractProvider implements ProviderInterface
{
    public function requiresConfiguration()
    {
        return false;
    }

    public function supportsDefaultValue()
    {
        return false;
    }

    /**
     * @param Property $property
     * @param Type $itemType
     * @throws Exception
     */
    public function getValues(Property $property)
    {
        return $this->_getValues($property);
    }

    abstract protected function _getValues(Property $property);

    public function getConfigurationValues()
    {
        if (!$this->requiresConfiguration()) {
            throw new \DevCtrl\Domain\Exception('this ValuesProvider does not require configuration');
        }
        return $this->_getConfigurationValues();
    }

    protected function _getConfigurationValues()
    {
        if ($this->requiresConfiguration()) {
            throw new \DevCtrl\Domain\Exception('no require configuration present! override this method');
        }
        return array();
    }

}

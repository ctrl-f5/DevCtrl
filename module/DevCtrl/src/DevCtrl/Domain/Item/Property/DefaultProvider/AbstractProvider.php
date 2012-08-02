<?php

namespace DevCtrl\Domain\Item\Property\DefaultProvider;

use DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\Type\TypeProperty;
use \DevCtrl\Domain\Exception;

abstract class AbstractProvider implements ProviderInterface
{
    public function getDefaultValue(Property $property, TypeProperty $typeProperty = null)
    {
        return $this->_getDefaultValue($property, $typeProperty);
    }

    abstract protected function _getDefaultValue(Property $property, TypeProperty $typeProperty = null);

    public function requiresValuesProvider()
    {
        return false;
    }

    public function requiresConfiguration()
    {
        return false;
    }
}

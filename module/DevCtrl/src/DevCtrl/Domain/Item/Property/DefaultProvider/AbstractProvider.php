<?php

namespace DevCtrl\Domain\Item\Property\DefaultProvider;

use DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\Type\TypeProperty;
use \DevCtrl\Domain\Exception;

abstract class AbstractProvider implements ProviderInterface
{
    public function getDefaultValue(TypeProperty $typeProperty = null)
    {
        return $this->_getDefaultValue($typeProperty);
    }

    abstract protected function _getDefaultValue(TypeProperty $typeProperty = null);

    public function requiresValuesProvider()
    {
        return false;
    }

    public function requiresConfiguration()
    {
        return false;
    }

    public function __toString()
    {
        return $this->getName();
    }
}

<?php

namespace DevCtrl\Domain\Item\Property\DefaultProvider;

use DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\Item;
use DevCtrl\Domain\Item\Type\TypeProperty;

class DefinedProvider extends AbstractProvider
{
    public function getName()
    {
        return 'Defined';
    }

    protected function _getDefaultValue(TypeProperty $typeProperty = null)
    {
        if (!$typeProperty->getProperty()->getType()->supportsDefaultValue()
        || !$typeProperty->getDefaultProvider())
            return null;

        return $typeProperty->getDefaultProviderConfig();
    }

    public function requiresConfiguration()
    {
        return true;
    }
}

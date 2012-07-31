<?php

namespace DevCtrl\Domain\Item\Property\DefaultProvider;

use DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\Item;

class EmptyProvider implements ProviderInterface
{
    public function getDefaultValue(Property $property)
    {
        return null;
    }
}

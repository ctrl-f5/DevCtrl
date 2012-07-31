<?php

namespace DevCtrl\Domain\Item\Property;

use DevCtrl\Domain\Item\Property;

class EmptyDefaultValueProvider implements DefaultValueProviderInterface
{
    public function getDefaultValue(Property $property)
    {
        return null;
    }
}

<?php

namespace DevCtrl\Domain\Item\Property;

use DevCtrl\Domain\Item\Property;

class StaticDefaultValueProvider implements DefaultValueProviderInterface
{
    public function getDefaultValue(Property $property)
    {
        return $property->getStaticDefaultValue();
    }
}

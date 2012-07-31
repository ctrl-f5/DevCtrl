<?php

namespace DevCtrl\Domain\Item\Property\DefaultProvider;

use DevCtrl\Domain\Item\Property\Property;

class StaticProvider implements ProviderInterface
{
    public function getDefaultValue(Property $property)
    {
        return $property->getStaticDefaultValue();
    }
}

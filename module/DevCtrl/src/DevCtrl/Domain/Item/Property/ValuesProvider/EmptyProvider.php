<?php

namespace DevCtrl\Domain\Item\Property\ValuesProvider;

use DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\Item;

class EmptyProvider implements ProviderInterface
{
    public function getValues(Property $property, Item $item = null)
    {
        return array();
    }
}

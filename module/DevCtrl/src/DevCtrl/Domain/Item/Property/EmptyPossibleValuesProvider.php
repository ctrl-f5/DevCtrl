<?php

namespace DevCtrl\Domain\Item\Property;

use DevCtrl\Domain\Item\Property;
use DevCtrl\Domain\Item\Item;

class EmptyPossibleValuesProvider implements PossibleValuesProviderInterface
{
    public function getPossibleValues(Property $property, Item $item = null)
    {
        return array();
    }
}

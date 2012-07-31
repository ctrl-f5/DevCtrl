<?php

namespace DevCtrl\Domain\Item\Property;

use DevCtrl\Domain\Item\Property;
use DevCtrl\Domain\Item\Item;

class FirstPossibleDefaultValueProvider implements DefaultValueProviderInterface
{
    public function getDefaultValue(Property $property)
    {
        $values = $property->getPossibleValues();
        if (count($values)) {
            return reset($values);
        }
        throw new \DevCtrl\Domain\DomainException('FirstPossible default value provider expects at least one PossibleValue');
    }
}

<?php

namespace DevCtrl\Domain\Item\Property\DefaultProvider;

use DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\Item;

class LastProvider implements ProviderInterface
{
    public function getDefaultValue(Property $property)
    {
        $values = $property->getPossibleValues();
        if (count($values)) {
            return end($values);
        }
        throw new \DevCtrl\Domain\Exception('FirstProvider expects at least one PossibleValue');
    }
}

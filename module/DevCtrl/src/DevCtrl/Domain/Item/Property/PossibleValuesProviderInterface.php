<?php

namespace DevCtrl\Domain\Item\Property;

use DevCtrl\Domain\Item\Property;
use DevCtrl\Domain\Item\Item;

interface PossibleValuesProviderInterface
{
    /**
     * @abstract
     * @param \DevCtrl\Domain\Item\Property $property
     * @param \DevCtrl\Domain\Item\Item $item
     * @return PossibleValue[]
     */
    public function getPossibleValues(Property $property, Item $item = null);
}

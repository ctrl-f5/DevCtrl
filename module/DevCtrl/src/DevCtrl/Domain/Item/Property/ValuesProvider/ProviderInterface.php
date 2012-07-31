<?php

namespace DevCtrl\Domain\Item\Property\ValuesProvider;

use DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\Property\Value;
use DevCtrl\Domain\Item\Item;

interface ProviderInterface
{
    /**
     * @abstract
     * @param \DevCtrl\Domain\Item\Property\Property $property
     * @param \DevCtrl\Domain\Item\Item $item
     * @return Value[]
     */
    public function getValues(Property $property, Item $item = null);
}

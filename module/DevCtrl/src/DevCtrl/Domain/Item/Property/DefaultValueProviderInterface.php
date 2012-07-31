<?php

namespace DevCtrl\Domain\Item\Property;

use DevCtrl\Domain\Item\Property;

interface DefaultValueProviderInterface
{
    public function getDefaultValue(Property $property);
}

<?php

namespace DevCtrl\Domain\Item\Property\DefaultProvider;

use DevCtrl\Domain\Item\Property\Property;

interface ProviderInterface
{
    public function getDefaultValue(Property $property);
}

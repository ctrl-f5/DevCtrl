<?php

namespace DevCtrl\Domain\Item\Property\DefaultProvider;

use DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\Type\TypeProperty;

interface ProviderInterface
{
    public function getName();
    public function getDefaultValue(TypeProperty $typeProperty = null);
    public function requiresValuesProvider();
    public function requiresConfiguration();
}

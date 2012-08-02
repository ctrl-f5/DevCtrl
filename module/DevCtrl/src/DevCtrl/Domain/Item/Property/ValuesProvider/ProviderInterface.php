<?php

namespace DevCtrl\Domain\Item\Property\ValuesProvider;

use DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\Type\Type;

interface ProviderInterface
{
    public function getName();
    public function getValues(Property $property, $config = null);
    public function requiresConfiguration();
    public function getConfigurationValues();
    public function supportsDefaultValue();
}

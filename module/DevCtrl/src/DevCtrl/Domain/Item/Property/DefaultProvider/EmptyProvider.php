<?php

namespace DevCtrl\Domain\Item\Property\DefaultProvider;

use DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\Item;
use DevCtrl\Domain\Item\Type\TypeProperty;

class EmptyProvider extends AbstractProvider
{
    public function getName()
    {
        return 'Empty';
    }

    protected function _getDefaultValue(TypeProperty $typeProperty = null)
    {
        return null;
    }
}

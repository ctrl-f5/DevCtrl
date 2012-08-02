<?php
namespace DevCtrl\Domain\Item\Property\Type;

use Ctrl\Domain\ServiceLocatorAwareModel;

class AbstractType extends ServiceLocatorAwareModel implements TypeInterface
{
    public function getNativeValueType()
    {
        return 'string';
    }

    public function getRepresentedPorpertyType()
    {
        return 'string';
    }

    public function supportsDefaultValue()
    {
        return false;
    }

    public function supportsProvidingValues()
    {
        return false;
    }
}

<?php
namespace DevCtrl\Domain\Item\Property\Type;

class SelectType implements TypeInterface
{
    public function supportsDefaultValue()
    {
        return true;
    }

    public function supportsProvidingValues()
    {
        return true;
    }

    public function getRepresentedPorpertyType()
    {
        return 'select';
    }

    public function getNativeValueType()
    {
        return 'string';
    }
}

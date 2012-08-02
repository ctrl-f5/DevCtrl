<?php
namespace DevCtrl\Domain\Item\Property\Type;

class StringType implements TypeInterface
{
    public function supportsDefaultValue()
    {
        return true;
    }

    public function supportsProvidingValues()
    {
        return false;
    }

    public function getRepresentedPorpertyType()
    {
        return 'string';
    }

    public function getNativeValueType()
    {
        return 'string';
    }
}

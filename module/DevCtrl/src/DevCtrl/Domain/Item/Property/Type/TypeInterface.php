<?php
namespace DevCtrl\Domain\Item\Property\Type;

interface TypeInterface
{
    public function getRepresentedPorpertyType();
    public function supportsDefaultValue();
    public function supportsProvidingValues();
    public function getNativeValueType();
}

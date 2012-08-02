<?php
namespace DevCtrl\Domain\Item\Property\Value;

interface NativeValueInterface
{
    public function getId();
    public function getValue();
    public function setValue($value);
}

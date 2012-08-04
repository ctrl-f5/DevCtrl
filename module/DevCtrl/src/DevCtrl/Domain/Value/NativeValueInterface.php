<?php
namespace DevCtrl\Domain\Value;

interface NativeValueInterface
{
    public function getId();
    public function getValue();
    public function setValue($value);
    public function getNativeValueType();
}

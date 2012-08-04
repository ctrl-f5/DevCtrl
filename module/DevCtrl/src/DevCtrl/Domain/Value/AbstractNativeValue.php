<?php
namespace DevCtrl\Domain\Value;

class AbstractNativeValue implements NativeValueInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $value;

    public function getId()
    {
        return $this->id;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
}

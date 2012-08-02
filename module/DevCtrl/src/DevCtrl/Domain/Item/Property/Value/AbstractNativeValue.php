<?php
namespace DevCtrl\Domain\Item\Property\Value;

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
        // TODO: Implement getId() method.
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

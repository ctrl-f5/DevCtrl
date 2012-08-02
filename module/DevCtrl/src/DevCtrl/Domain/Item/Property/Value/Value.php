<?php

namespace DevCtrl\Domain\Item\Property\Value;

class Value extends AbstractNativeValue
{
    protected static $nativeValueTypes = array(
        'string' => array(
            'name' => 'String',
            'class' => '\DevCtrl\Domain\Item\Property\Value\StringValue'
        ),
        'text' => array(
            'name' => 'Text',
            'class' => '\DevCtrl\Domain\Item\Property\Value\TextValue'
        ),
        'integer' => array(
            'name' => 'Int',
            'class' => '\DevCtrl\Domain\Item\Property\Value\IntValue'
        ),
    );

    public static function getNativeValueTypes()
    {
        return self::$nativeValueTypes;
    }

    /**
     * @var int
     */
    protected $id;

    /**
     * @var NativeValueInterface
     */
    protected $value;

    /**
     * @var string
     */
    protected $nativeType;

    /**
     * @param int $id
     * @return Value
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $value
     * @return Value
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return NativeValueInterface
     */
    public function getValue()
    {
        return $this->value;
    }
}

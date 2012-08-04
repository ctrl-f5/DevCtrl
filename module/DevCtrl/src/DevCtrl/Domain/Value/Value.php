<?php

namespace DevCtrl\Domain\Value;

use DevCtrl\Domain\Collection;
use DevCtrl\Domain\Item\Property\Value\ValueList as PropertyValueList;

class Value extends AbstractNativeValue
{
    protected static $nativeValueTypes = array(
        'string' => array(
            'name' => 'String',
            'class' => '\DevCtrl\Domain\Value\StringValue'
        ),
        'text' => array(
            'name' => 'Text',
            'class' => '\DevCtrl\Domain\Value\TextValue'
        ),
        'integer' => array(
            'name' => 'Int',
            'class' => '\DevCtrl\Domain\Value\IntValue'
        ),
    );

    /**
     * @var NativeValueInterface
     */
    protected $value;

    /**
     * @var string
     */
    protected $nativeType;

    /**
     * @var PropertyValueList[]
     */
    protected $propertyValueLists;

    public function __construc()
    {
        $this->list = new Collection();
    }

    public static function getNativeValueTypes()
    {
        return self::$nativeValueTypes;
    }

    /**
     * @param $lists
     * @return Value
     */
    public function setPropertyValueLists($lists)
    {
        $this->propertyValueLists = $lists;
        return $this;
    }

    /**
     * @return PropertyValueList
     */
    public function getPropertyValueList()
    {
        return $this->propertyValueLists;
    }

}

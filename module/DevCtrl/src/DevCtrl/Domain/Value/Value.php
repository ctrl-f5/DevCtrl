<?php

namespace DevCtrl\Domain\Value;

use DevCtrl\Domain\Collection;
use DevCtrl\Domain\Item\Property\Value\ValueList as PropertyValueList;
use DevCtrl\Domain\Item\ItemProperty;

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
        )
    );

    /**
     * @var NativeValueInterface
     */
    protected $value;

    /**
     * @var string
     */
    protected $nativeType;

    /** @var ItemProperty[] */
    protected $itemProperties;

    public function __construc()
    {
        $this->list = new Collection();
    }

    public static function getNativeValueTypes()
    {
        return self::$nativeValueTypes;
    }

    public static function getNativeValueInstance($type)
    {
        if (!isset(self::$nativeValueTypes[$type]))
            throw new \Devctrl\Exception('NativeValue not found: '.$type);

        return new self::$nativeValueTypes[$type]['class'];
    }
}

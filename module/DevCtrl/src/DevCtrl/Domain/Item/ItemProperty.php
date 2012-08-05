<?php

namespace DevCtrl\Domain\Item;

use \DevCtrl\Domain;
use \DevCtrl\Domain\Item\Item;
use \DevCtrl\Domain\Item\Type\TypeProperty;
use DevCtrl\Domain\Item\Property\Property;
use Ctrl\Domain\PersistableModel;
use DevCtrl\Domain\Value\NativeValueInterface;
use DevCtrl\Domain\Value\Value;

class ItemProperty extends PersistableModel
{
    /**
     * @var Item
     */
    protected $item;

    /**
     * @var NativeValueInterface
     */
    protected $value;

    /**
     * @var TypeProperty
     */
    protected $typeProperty;

    public function __construct(TypeProperty $typeProperty)
    {
        $this->typeProperty = $typeProperty;
    }

    /**
     * @param Item $item
     * @return ItemProperty
     */
    public function setItem($item)
    {
        $this->item = $item;
        return $this;
    }

    /**
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param mixed $value
     * @return ItemProperty
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
        if (!$this->value) {
            $this->value = Value::getNativeValueInstance($this->getTypeProperty()->getProperty()->getType()->getNativeValueType());
        }
        return $this->value;
    }

    public function getDisplayValue()
    {
        $prop = $this->getTypeProperty()->getProperty();
        if ($prop->getType()->supportsProvidingValues() && $prop->getValuesProvider()) {
            $values = $prop->getValuesProvider()->getValues($prop);
            if (isset($values[$this->getValue()->getValue()])) {
                return $values[$this->getValue()->getValue()];
            }
            return null;
        }
        return $this->getValue()->getValue();
    }

    /**
     * @param TypeProperty $typeProperty
     * @return ItemProperty
     */
    public function setTypeProperty($typeProperty)
    {
        $this->typeProperty = $typeProperty;
        return $this;
    }

    /**
     * @return TypeProperty
     */
    public function getTypeProperty()
    {
        return $this->typeProperty;
    }
}

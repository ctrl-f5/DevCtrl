<?php

namespace DevCtrl\Domain\Item;

use \DevCtrl\Domain;
use \DevCtrl\Domain\Item\Item;
use \DevCtrl\Domain\Item\Type\TypeProperty;
use DevCtrl\Domain\Item\Property\Value\NativeValueInterface;

class PropertyValue
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Item
     */
    protected $item;

    /**
     * @var TypeProperty
     */
    protected $property;

    /**
     * @var NativeValueInterface
     */
    protected $value;

    /**
     * @param int $id
     * @return PropertyValue
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
     * @param Item $item
     * @return PropertyValue
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
     * @param Property $property
     * @return PropertyValue
     */
    public function setProperty($property)
    {
        $this->property = $property;
        return $this;
    }

    /**
     * @return Property
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param mixed $value
     * @return PropertyValue
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}

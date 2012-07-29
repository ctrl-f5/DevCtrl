<?php

namespace DevCtrl\Domain\Item;

use \DevCtrl\Domain;

class ItemPropertyValue
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
     * @var Property
     */
    protected $property;

    /**
     * @var mixed
     */
    protected $value;


    /**
     * @param int $id
     * @return ItemPropertyValue
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
     * @param \DevCtrl\Domain\Item\Item $item
     * @return ItemPropertyValue
     */
    public function setItem($item)
    {
        $this->item = $item;
        return $this;
    }

    /**
     * @return \DevCtrl\Domain\Item\Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param \DevCtrl\Domain\Item\Property $property
     * @return ItemPropertyValue
     */
    public function setProperty($property)
    {
        $this->property = $property;
        return $this;
    }

    /**
     * @return \DevCtrl\Domain\Item\Property
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param mixed $value
     * @return ItemPropertyValue
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

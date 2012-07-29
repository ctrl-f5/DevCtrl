<?php

namespace DevCtrl\Domain\Item;

use \DevCtrl\Domain;

class ItemTypeProperty
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var ItemType
     */
    protected $itemType;

    /**
     * @var Property
     */
    protected $property;

    /**
     * @var bool
     */
    protected $required = false;

    /**
     * @param int $id
     * @return ItemTypeProperty
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
     * @param \DevCtrl\Domain\Item\Property $property
     * @return ItemTypeProperty
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
     * @param boolean $required
     * @return ItemTypeProperty
     */
    public function setRequired($required)
    {
        $this->required = (bool)$required;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getRequired()
    {
        return (bool)$this->required;
    }

    /**
     * @param \DevCtrl\Domain\Item\ItemType $itemType
     * @return ItemTypeProperty
     */
    public function setItemType($itemType)
    {
        $this->itemType = $itemType;
        return $this;
    }

    /**
     * @return \DevCtrl\Domain\Item\ItemType
     */
    public function getItemType()
    {
        return $this->itemType;
    }
}

<?php

namespace DevCtrl\Domain\Item\Type;

use \DevCtrl\Domain;
use \DevCtrl\Domain\Item\Item;
use \DevCtrl\Domain\Item\Property\Property;

class TypeProperty
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Type
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
     * @return TypeProperty
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
     * @param Property $property
     * @return TypeProperty
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
     * @param boolean $required
     * @return TypeProperty
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
     * @param \DevCtrl\Domain\Item\Type\Type $itemType
     * @return TypeProperty
     */
    public function setItemType($itemType)
    {
        $this->itemType = $itemType;
        return $this;
    }

    /**
     * @return \DevCtrl\Domain\Item\Type\Type
     */
    public function getItemType()
    {
        return $this->itemType;
    }
}

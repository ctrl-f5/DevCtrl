<?php

namespace DevCtrl\Domain\Item;

use \DevCtrl\Domain;
use \DevCtrl\Domain\Item\Property\Property;

class Item
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var Type\Type
     */
    protected $itemType;

    /**
     * @var State
     */
    protected $state;

    /**
     * @var ItemProperty[]
     */
    protected $itemProperties;

    /**
     * @param string $description
     * @return Item
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param \DevCtrl\Domain\Item\State $state
     * @return Item
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return \DevCtrl\Domain\Item\State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $title
     * @return Item
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return \DevCtrl\Domain\Item\Type\Type
     */
    public function getItemType()
    {
        return $this->itemType;
    }

    public function setItemProperties($itemProperties)
    {
        $this->itemProperties = $itemProperties;
        return $this;
    }

    public function getItemProperties()
    {
        return $this->itemProperties;
    }

    /**
     * @param Property\Property $property
     * @return ItemProperty
     * @throws Domain\Exception
     */
    public function getItemProperty(Property $property)
    {
        foreach ($this->getItemProperties() as $ip) {
            if ($ip->getTypeProperty()->getProperty()->getId() === $property->getId()) {
                return $ip;
            }
        }
        throw new Domain\Exception('Item has no PropertyValue for the given Property');
    }

    protected function hasAllRequiredPropertyValues()
    {
        foreach ($this->getItemType()->getTypeProperties() as $itp) {
            $val = null;
            foreach ($this->getPropertyValues() as $pv) {
                if ($pv->getProperty() === $itp->getProperty()) {
                    $val = $pv->getValue();
                    break;
                }
            }
            if ($itp->getRequired() && !$val) {
                return false;
            }
        }
        return true;
    }
}

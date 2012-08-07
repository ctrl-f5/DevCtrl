<?php

namespace DevCtrl\Domain\Item\Type;

use DevCtrl\Domain\Item\Item;
use DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\Type\TypeProperty;
use DevCtrl\Domain\Item\State\StateList;
use DevCtrl\Domain\Item\State\State;
use DevCtrl\Domain\Exception;
use DevCtrl\Domain\Collection;

class Type extends \Ctrl\Domain\PersistableModel
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var bool
     */
    protected $supportsTiming = false;

    /**
     * @var Collection|TypeProperty[]
     */
    protected $typeProperties;

    /**
     * @var StateList
     */
    protected $states;

    public function __construct($supportsTiming)
    {
        $this->supportsTiming = (bool)$supportsTiming;

        $this->typeProperties = new Collection();
    }

    /**
     * @param string $description
     * @return Type
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
     * @param string $name
     * @return Type
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param TypeProperty $typeProperty
     * @return Type
     * @throws Exception
     */
    public function addProperty(TypeProperty $typeProperty)
    {
        foreach ($this->typeProperties as $p)
            if ($p->getProperty()->getId() == $typeProperty->getProperty()->getId())
                throw new \DevCtrl\Domain\Exception('Item\Property\Property already linked to this Item\Type\Type');

        $typeProperty->setItemType($this);
        $typeProperty->setOrder(
            $this->getTypeProperties()->count()
        );
        $this->typeProperties[] = $typeProperty;

        return $this;
    }

    /**
     * @param TypeProperty[] $properties
     * @return Type
     */
    public function setTypeProperties($properties)
    {
        $this->typeProperties = $properties;
        return $this;
    }

    /**
     * @return TypeProperty[]
     */
    public function getTypeProperties()
    {
        return $this->typeProperties;
    }

    /**
     * @param Property $property
     * @return TypeProperty
     * @throws Exception
     */
    public function getTypeProperty(Property $property)
    {
        foreach ($this->typeProperties as $tp) {
            if ($tp->getProperty()->getId() == $property->getId()) {
                return $tp;
            }
        }
        throw new Exception('Property not found');
    }

    /**
     * @return boolean
     */
    public function supportsTiming()
    {
        return (bool)$this->supportsTiming;
    }

    /**
     * @param \DevCtrl\Domain\Item\State\StateList $list
     * @return Type
     */
    public function setStates(StateList $list = null)
    {
        $this->states = $list;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasStates()
    {
        return $this->states instanceof StateList;
    }

    /**
     * @return StateList
     */
    public function getStates()
    {
        return $this->states;
    }
}

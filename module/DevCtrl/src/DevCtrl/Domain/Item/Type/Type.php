<?php

namespace DevCtrl\Domain\Item\Type;

use DevCtrl\Domain;
use DevCtrl\Domain\Item\Property\Property;

class Type
{
    /**
     * @var int
     */
    protected $id;

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
    protected $timed = false;

    /**
     * @var bool
     */
    protected $hasState = false;

    /**
     * @var Domain\Collection|TypeProperty[]
     */
    protected $typeProperties;

    /**
     * @var Domain\Collection|State[]
     */
    protected $states;

    public function __construct()
    {
        $this->typeProperties = new Domain\Collection();
        $this->states = new Domain\Collection();
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
     * @param int $id
     * @return Type
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
     * @param Property $property
     * @param bool $required
     * @return Type
     * @throws \DevCtrl\Domain\Exception
     */
    public function addProperty(Property $property, $required = false)
    {
        foreach ($this->typeProperties as $p)
            if ($p->getProperty()->getId() == $property->getId())
                throw new \DevCtrl\Domain\Exception('Item\Property\Property already linked to this Item\Type\Type');

        $typeProperty = new TypeProperty();
        $typeProperty->setItemType($this)
            ->setProperty($property)
            ->setRequired($required);

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
     * @param boolean $timed
     * @return Type
     */
    public function setTimed($timed)
    {
        $this->timed = (bool)$timed;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getTimed()
    {
        return (bool)$this->timed;
    }

    /**
     * @param boolean $hasState
     * @return Type
     */
    public function setHasState($hasState)
    {
        $this->hasState = (bool)$hasState;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getHasState()
    {
        return (bool)$this->hasState;
    }

    /**
     * @param $states
     * @return Type
     */
    public function setStates($states)
    {
        $this->states = $states;
        return $this;
    }

    /**
     * @return Domain\Collection|State[]
     */
    public function getStates()
    {
        return $this->states;
    }

    /**
     * @param $id
     * @return State|null
     */
    public function getState($id)
    {
        foreach ($this->getStates() as $s) {
            if ($s->getId() == $id) return $s;
        }
        return null;
    }

    /**
     * @param State $state
     * @return Type
     */
    public function addState(State $state)
    {
        $state->setItemType($this)
            ->setOrder(
                count($this->states) + 1
            );
        $this->states[] = $state;

        return $this;
    }
}

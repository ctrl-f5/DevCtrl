<?php

namespace DevCtrl\Domain\Item;

use DevCtrl\Domain;

class ItemType
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
     * @var Domain\Collection|ItemTypeProperty[]
     */
    protected $itemTypeProperties;

    /**
     * @var Domain\Collection|State[]
     */
    protected $states;

    public function __construct()
    {
        $this->itemTypeProperties = new Domain\Collection();
        $this->states = new Domain\Collection();
    }

    /**
     * @param string $description
     * @return ItemType
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
     * @return ItemType
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
     * @return ItemType
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
     * @return ItemType
     */
    public function addProperty(Property $property, $required = false)
    {
        $itemTypeProperty = new ItemTypeProperty();
        $itemTypeProperty->setItemType($this)->setProperty($property)->setRequired($required);
        $this->itemTypeProperties[] = $itemTypeProperty;
        return $this;
    }

    /**
     * @param \DevCtrl\Domain\Item\ItemTypeProperty $itemTypeProperties
     * @return ItemType
     */
    public function setItemTypeProperties($itemTypeProperties)
    {
        $this->itemTypeProperties = $itemTypeProperties;
        return $this;
    }

    /**
     * @return \DevCtrl\Domain\Item\ItemTypeProperty[]
     */
    public function getItemTypeProperties()
    {
        return $this->itemTypeProperties;
    }

    /**
     * @param boolean $timed
     * @return ItemType
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
     * @return ItemType
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
     * @return ItemType
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
     * @return ItemType
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

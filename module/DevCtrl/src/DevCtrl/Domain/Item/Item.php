<?php

namespace DevCtrl\Domain\Item;

use \DevCtrl\Domain;
use DevCtrl\Domain\Project;
use DevCtrl\Domain\Item\Type\Type;
use DevCtrl\Domain\Item\State\State;
use \DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\Timing\Counter;

class Item extends \Ctrl\Domain\PersistableModel
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

    protected $timeCounter;

    /** @var Project */
    protected $project;

    /**
     * @var ItemProperty[]
     */
    protected $itemProperties;

    public function __construct(Type $type)
    {
        $this->itemProperties = new \DevCtrl\Domain\Collection();
        $this->itemType = $type;
    }

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
     * @param State $state
     * @return Item
     */
    public function setState($state)
    {
        $this->setStateById($state->getId());
        return $this;
    }

    public function setStateById($state)
    {
        foreach ($this->getItemType()->getStates()->getStates() as $s) {
            if ($s->getId() == $state) {
                $this->state = $s;
                return $this;
            }
        }
        throw new Exception('State not found');
    }

    /**
     * @return State
     */
    public function getState()
    {
        if ($this->getItemType()->hasStates())
            return $this->state;
        return null;
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

    /**
     * @return ItemProperty[]
     */
    public function getItemProperties()
    {
        /** @var $model ItemProperty */
        $ordered = $this->_orderModelArray($this->itemProperties, function ($model) {
            return $model->getTypeProperty()->getOrder();
        });
        return new \DevCtrl\Domain\Collection($ordered);
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
        throw new Exception('Property not found in Item');
    }

    /**
     * @param Property\Property $property
     * @param mixed $value
     * @return ItemProperty
     * @throws Domain\Exception
     */
    public function setItemProperty(Property $property, $value)
    {
        try {
            return $this->getItemProperty($property);
        } catch (Exception $e) { // only catch Domain\Item\Exceptions!
            foreach ($this->getItemType()->getTypeProperties() as $tp) {
                if ($tp->getProperty()->getId() === $property->getId()) {
                    $itemProp = new ItemProperty($tp);
                    $itemProp->setItem($this)
                        ->setTypeProperty($tp)
                        ->getValue()->setValue($value);
                    $this->itemProperties[] = $itemProp;
                    return $this;
                }
            }
        }
        throw new Exception('Property not found in Item');
    }

    protected function hasAllRequiredPropertyValues()
    {
        foreach ($this->getItemType()->getTypeProperties() as $itp) {
            $val = null;
            foreach ($this->getItemProperties() as $pv) {
                if ($pv->getTypeProperty()->getProperty() === $itp->getProperty()) {
                    $val = $pv->getValue()->getValue();
                    break;
                }
            }
            if ($itp->getRequired() && !$val) {
                return false;
            }
        }
        return true;
    }

    public function setTimeCounter($timeCounter)
    {
        $this->timeCounter = $timeCounter;
        return $this;
    }

    /**
     * @return Counter
     */
    public function getTimeCounter()
    {
        return $this->timeCounter;
    }

    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param Project $project
     * @return Item
     */
    public function setProject(Project $project)
    {
        $this->project = $project;
        return $this;
    }
}

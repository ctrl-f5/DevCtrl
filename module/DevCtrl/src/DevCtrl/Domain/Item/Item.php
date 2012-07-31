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
     * @var Domain\Collection|PropertyValue[]
     */
    protected $propertyValues;

    /**
     * @var Domain\Project
     */
    protected $project;

    /**
     * @var Domain\User
     */
    protected $createdByUser;

    /**
     * @var Domain\Collection|Domain\User[]
     */
    protected $assignedUsers;

    /**
     * @param $title
     * @param Domain\User $createdBy
     * @param Domain\Project $project
     * @param Type\Type $itemType
     * @param PropertyValue[] $propertyValues
     * @throws Domain\Exception
     */
    public function __construct($title, Domain\User $createdBy, Domain\Project $project, Type\Type $itemType, $propertyValues)
    {
        $this->title = $title;
        $this->createdByUser = $createdBy;
        $this->project = $project;
        $this->itemType = $itemType;

        $this->propertyValues = new Domain\Collection();
        $this->assignedUsers = new Domain\Collection();

        foreach ($propertyValues as $pv) {
            $this->addPropertyValue($pv);
        }
        if (!$this->hasAllRequiredPropertyValues()) {
            throw new Domain\Exception('item is missing a required property value');
        }
    }

    public function setAssignedUsers($assignedUsers)
    {
        $this->assignedUsers = $assignedUsers;
        return $this;
    }

    public function getAssignedUsers()
    {
        return $this->assignedUsers;
    }

    /**
     * @param \DevCtrl\Domain\User $createdByUser
     * @return Item
     */
    public function setCreatedByUser($createdByUser)
    {
        $this->createdByUser = $createdByUser;
        return $this;
    }

    /**
     * @return \DevCtrl\Domain\User
     */
    public function getCreatedByUser()
    {
        return $this->createdByUser;
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
     * @param int $id
     * @return Item
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

    public function setPropertyValues($propertyValues)
    {
        $this->propertyValues = $propertyValues;
        return $this;
    }

    public function getPropertyValues()
    {
        return $this->propertyValues;
    }

    public function getPropertyValue(Property $property)
    {
        foreach ($this->getPropertyValues() as $pv) {
            if ($pv->getProperty() === $property) {
                return $pv;
            }
        }
        throw new Domain\Exception('Item has no PropertyValue for the given Property');
    }

    public function addPropertyValue(PropertyValue $propertyValue)
    {
        $this->propertyValues[] = $propertyValue;
        $propertyValue->setItem($this);
        return $this;
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

    /**
     * @param \DevCtrl\Domain\Project $project
     * @return Item
     */
    public function setProject($project)
    {
        $this->project = $project;
        return $this;
    }

    /**
     * @return \DevCtrl\Domain\Project
     */
    public function getProject()
    {
        return $this->project;
    }

}

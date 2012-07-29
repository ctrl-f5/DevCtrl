<?php

namespace DevCtrl\Domain\Item;

use \DevCtrl\Domain;

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
     * @var ItemType
     */
    protected $itemType;

    /**
     * @var State
     */
    protected $state;

    /**
     * @var Domain\Collection|ItemPropertyValue[]
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

    public function __construct()
    {
        $this->properties = new Domain\Collection();
        $this->assignedUsers = new Domain\Collection();
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
     * @param \DevCtrl\Domain\Item\ItemType $itemType
     * @return Item
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

    public function setPropertyValues($propertyValues)
    {
        $this->propertyValues = $propertyValues;
        return $this;
    }

    public function getPropertyValues()
    {
        return $this->propertyValues;
    }

    public function setPropertyValue(Property $property, $value)
    {
        foreach ($this->getPropertyValues() as $pv) {
            if ($pv->getProperty() === $property) {
                $pv->setValue($value);
            }
        }
    }

    public function addPropertyValue(ItemPropertyValue $itemPropertyValue)
    {
        $this->propertyValues[] = $itemPropertyValue;
        return $this;
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

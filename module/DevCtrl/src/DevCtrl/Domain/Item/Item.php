<?php

namespace DevCtrl\Domain\Item;

use \DevCtrl\Domain;
use DevCtrl\Domain\Project\Project;
use DevCtrl\Domain\Project\Milestone;
use DevCtrl\Domain\Item\ItemRelation;
use DevCtrl\Domain\User\User;
use DevCtrl\Domain\Item\Type\Type;
use DevCtrl\Domain\Item\State\State;
use \DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\Timing\Counter;
use DevCtrl\Domain\Project\Version;
use DateTime;

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

    /**
     * @var DateTime
     */
    protected $dateCreated;

    /**
     * @var DateTime
     */
    protected $dateUpdate;

    /**
     * @var User[]
     */
    protected $assignedUsers;

    /**
     * @var ItemRelation[]
     */
    protected $itemRelations;

    /**
     * @var User
     */
    protected $createdBy;

    /**
     * @var Version
     */
    protected $versionReported;

    /**
     * @var Version
     */
    protected $versionFixed;

    /**
     * @var Milestone[]
     */
    protected $milestones;

    public function __construct(Type $type, User $createdBy)
    {
        $this->itemProperties = new \DevCtrl\Domain\Collection();
        $this->itemRelations = new \DevCtrl\Domain\Collection();
        $this->assignedUsers = new \DevCtrl\Domain\Collection();
        $this->milestones = new \DevCtrl\Domain\Collection();
        $this->itemType = $type;
        $this->createdBy = $createdBy;
        $this->dateCreated = new DateTime();
        $this->touch();
    }

    public function touch()
    {
        $this->dateUpdate = new DateTime();
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
        if ($this->getItemType()->supportsStates())
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

    public function getProgress()
    {
        if ($this->getItemType()->supportsTiming()) {
            if ($this->getItemType()->supportsStates() && $this->getState()->getNativeState() == State::STATE_CLOSED) {
                return 100;
            } else {
                $est = $this->getTimeCounter()->getEstimated();
                if ($est) {
                    return round($this->getTimeCounter()->getExecuted()/$est*100);
                }
                return 0;
            }
        }
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

    /**
     * @return DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param \DevCtrl\Domain\User\User $user
     */
    public function assignUser(User $user)
    {
        $this->assignedUsers[] = $user;
    }

    /**
     * @return \DevCtrl\Domain\User\User[]
     */
    public function getAssignedUsers()
    {
        return $this->assignedUsers;
    }

    /**
     * @param Item $item
     * @param $relationType
     * @return Item
     */
    public function addRelatedItem(Item $item, $relationType)
    {
        if (!in_array($relationType, ItemRelation::getTypes())) {
            throw new Exception('invalid relation type: '.$relationType);
        }
        foreach ($this->getItemRelations() as $rel) {
            if ($rel->getRelatedItem()->getId() == $item->getId() && $relationType == $rel->getType()) throw new DuplicateItemRelationException();
        }

        $relation = new ItemRelation();
        $relation->setItem($this)
            ->setRelatedItem($item)
            ->setType($relationType);
        $this->itemRelations[] = $relation;

        try {
            $item->addRelatedItem($this, ItemRelation::getOppositeType($relationType));
        } catch (DuplicateItemRelationException $e) {}

        return $this;
    }

    /**
     * @return ItemRelation[]
     */
    public function getItemRelations()
    {
        return $this->itemRelations;
    }

    /**
     * @param \DevCtrl\Domain\Project\Version $versionFixed
     */
    public function setVersionFixed($versionFixed = null)
    {
        $this->versionFixed = $versionFixed;
        return $this;
    }

    /**
     * @return \DevCtrl\Domain\Project\Version
     */
    public function getVersionFixed()
    {
        return $this->versionFixed;
    }

    /**
     * @param \DevCtrl\Domain\Project\Version $versionReported
     */
    public function setVersionReported($versionReported = null)
    {
        $this->versionReported = $versionReported;
        return $this;
    }

    /**
     * @return \DevCtrl\Domain\Project\Version
     */
    public function getVersionReported()
    {
        return $this->versionReported;
    }

    /**
     * @return Milestone[]
     */
    public function getMilestones()
    {
        return $this->milestones;
    }
}

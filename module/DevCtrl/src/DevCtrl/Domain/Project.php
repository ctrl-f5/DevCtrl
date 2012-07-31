<?php

namespace DevCtrl\Domain;

class Project
{
    const STATE_ACTIVE      = 'active';
    const STATE_SLEEPING    = 'sleeping';
    const STATE_LOCKED      = 'locked';
    const STATE_CLOSED      = 'closed';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Project|null
     */
    protected $parentProject;

    /**
     * @var \Auth\Domain\User
     */
    protected $createdByUser;

    /**
     * @var \DateTime
     */
    protected $dateCreated;

    /**
     * @var \DateTime
     */
    protected $dateDue;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var Collection
     */
    protected $linkedUsers;

    /**
     * @var Collection
     */
    protected $items;

    /**
     * @var Version[]|Collection
     */
    protected $versions;

    public function __construct()
    {
        $this->linkedUsers = new Collection();
        $this->items = new Collection();
        $this->versions = new Collection();
    }

    /**
     * @param \Auth\Domain\User $createdByUser
     * @return Project
     */
    public function setCreatedByUser($createdByUser)
    {
        $this->createdByUser = $createdByUser;
        return $this;
    }

    /**
     * @return \Auth\Domain\User
     */
    public function getCreatedByUser()
    {
        return $this->createdByUser;
    }

    /**
     * @param \DateTime $dateCreated
     * @return Project
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param \DateTime $dateDue
     * @return Project
     */
    public function setDateDue($dateDue)
    {
        $this->dateDue = $dateDue;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateDue()
    {
        return $this->dateDue;
    }

    /**
     * @param int $id
     * @return Project
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
     * @return Project
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
     * @param \Auth\Domain\Project|null $parentProject
     * @return Project
     */
    public function setParentProject($parentProject)
    {
        $this->parentProject = $parentProject;
        return $this;
    }

    /**
     * @return \Auth\Domain\Project|null
     */
    public function getParentProject()
    {
        return $this->parentProject;
    }

    /**
     * @param string $state
     * @return Project
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return \DevCtrl\Domain\Collection|ProjectUserLink[]
     */
    public function getLinkedUsers()
    {
        return $this->linkedUsers;
    }

    /**
     * @return Collection|\DevCtrl\Domain\Item\Item[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param Item\Item $item
     * @return Project
     */
    public function addItem(Item\Item $item)
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @param Version[] $versions
     * @return Project
     */
    public function setVersions($versions)
    {
        $this->versions = $versions;
        return $this;
    }

    /**
     * @return Collection|Version[]
     */
    public function getVersions()
    {
        return $this->versions;
    }
}
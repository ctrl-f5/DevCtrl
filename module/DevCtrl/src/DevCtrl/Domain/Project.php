<?php

namespace DevCtrl\Domain;

use Ctrl\Domain\PersistableModel;
use DevCtrl\Domain\Item\Item;

class Project extends PersistableModel
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
     * @var Item[]
     */
    protected $backlog;

    /**
     * @var Version[]|Collection
     */
    protected $versions;

    public function __construct()
    {
        $this->backlog = new Collection();
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
     * @return Item[]
     */
    public function getBacklog()
    {
        return $this->backlog;
    }

    /**
     * @param Item $item
     * @return Project
     */
    public function addToBacklog(Item $item)
    {
        $this->backlog[] = $item;
        return $this;
    }

    /**
     * @param string $description
     * @return Project
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
}
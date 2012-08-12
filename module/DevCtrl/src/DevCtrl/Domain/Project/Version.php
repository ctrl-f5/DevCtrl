<?php

namespace DevCtrl\Domain\Project;

use Ctrl\Domain\PersistableModel;

class Version extends PersistableModel
{
    /**
     * @var Project
     */
    protected $project;

    /**
     * @var string
     */
    protected $version;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var bool
     */
    protected $released = false;

    /**
     * @var int
     */
    protected $order;

    /**
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
        $project->addVersion($this);
    }

    /**
     * @param string $description
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
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param int $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return \DevCtrl\Domain\Project\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param $released
     * @return Version
     */
    public function setReleased($released)
    {
        $this->released = $released;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getReleased()
    {
        return $this->released;
    }
}

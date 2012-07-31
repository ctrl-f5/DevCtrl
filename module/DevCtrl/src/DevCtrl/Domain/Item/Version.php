<?php

namespace DevCtrl\Domain;

class Version
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Project
     */
    protected $project;

    /**
     * @var int
     */
    protected $order;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->setProject($project);
    }

    /**
     * @param int $id
     * @return Version
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
     * @return Version
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
     * @param int $order
     * @return Version
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param \DevCtrl\Domain\Project $project
     * @return Version
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

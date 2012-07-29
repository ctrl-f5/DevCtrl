<?php
namespace DevCtrl\Domain;

class ProjectUserLink
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
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    protected $level;

    /**
     * @param int $id
     * @return ProjectUserLink
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
     * @param string $level
     * @return ProjectUserLink
     */
    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param \DevCtrl\Domain\Project $project
     * @return ProjectUserLink
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

    /**
     * @param \DevCtrl\Domain\User $user
     * @return ProjectUserLink
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return \DevCtrl\Domain\User
     */
    public function getUser()
    {
        return $this->user;
    }
}

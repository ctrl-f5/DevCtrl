<?php

namespace DevCtrl\Domain;

class User
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $firstname;

    /**
     * @var string
     */
    protected $lastname;

    /**
     * @var \Auth\Domain\User
     */
    protected $authUser;

    /**
     * @var Collection|ProjectUserLink[]
     */
    protected $linkedProjects;

    public function __construct()
    {
        $this->linkedProjects = new Collection();
    }

    /**
     * @param Project $project
     * @return bool|ProjectUserLink
     */
    public function getProjectLink(Project $project)
    {
        foreach ($this->linkedProjects as $p) {
            if ($p->getProject()->getId() == $project->getId())
                return $p;
        }
        return false;
    }

    public function getAuthUser()
    {
        return $this->authUser;
    }

    public function getId()
    {
        return $this->id;
    }
}

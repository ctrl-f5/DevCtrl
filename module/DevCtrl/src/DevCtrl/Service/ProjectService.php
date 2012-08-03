<?php

namespace DevCtrl\Service;

use \DevCtrl\Domain;

class ProjectService extends \Ctrl\Service\AbstractDomainModelService
{
    protected $entity = 'DevCtrl\Domain\Project';

    public function getUsersNotLinkedToProject(Domain\Project $project)
    {
        $id = $project->getId();
        return $this->getEntityManager()
            ->createQuery(
                "SELECT u FROM DevCtrl\\Domain\\User u
                 WHERE u.id NOT IN (
                    SELECT pulu.id FROM DevCtrl\\Domain\\ProjectUserLink pul
                    JOIN pul.user pulu
                    WHERE pul.project = $id
                 )"
            )
            ->getResult();
    }

    public function linkUserToProject(\DevCtrl\Domain\Project $project, \DevCtrl\Domain\User $user, $level)
    {
        $projectUserLink = new \DevCtrl\Domain\ProjectUserLink();
        $projectUserLink
            ->setProject($project)
            ->setUser($user)
            ->setLevel($level);

        $this->getEntityManager()->persist($projectUserLink);
        $this->getEntityManager()->flush();
    }
}

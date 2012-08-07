<?php

namespace DevCtrl\Service;

use \DevCtrl\Domain;
use DevCtrl\Domain\Project;
use DevCtrl\Domain\Item\Item;

class ProjectService extends \Ctrl\Service\AbstractDomainModelService
{
    protected $entity = 'DevCtrl\Domain\Project';

    /**
     * @param \DevCtrl\Domain\Project $project
     * @return Item[]
     */
    public function getBacklogItems(Project $project)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT i FROM DevCtrl\Domain\Item\Item i JOIN i.project p
                WHERE p.id = :id
                ORDER BY i.dateCreated DESC')
            ->setParameter('id', $project)
            ->getResult();
    }
}

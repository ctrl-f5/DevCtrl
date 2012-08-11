<?php

namespace DevCtrl\Service;

use \DevCtrl\Domain;
use Ctrl\Service\AbstractDomainModelService;
use DevCtrl\Domain\Item\Item;

class UserService extends AbstractDomainModelService
{
    protected $entity = 'DevCtrl\Domain\User\User';

    public function getCurrentUser()
    {
        return $this->getById(1);
    }

    public function getUsersNotAssignedToItem(Item $item)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT u FROM '.$this->entity.' u WHERE u.id NOT IN(
                SELECT iu.id FROM DevCtrl\Domain\Item\Item i JOIN i.assignedUsers iu WHERE i.id = :itemId
            )')
            ->setParameter('itemId', $item->getId())
            ->getResult();
    }
}

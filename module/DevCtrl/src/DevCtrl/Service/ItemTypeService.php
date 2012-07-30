<?php

namespace DevCtrl\Service;

use \DevCtrl\Domain;

class ItemTypeService extends \Ctrl\Service\AbstractDomainEntityService
{
    protected $entity = 'DevCtrl\Domain\Item\ItemType';

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT e FROM '.$this->entity.' e'
            )
            ->getResult();
    }

    public function getById($id)
    {
        $entities = $this->getEntityManager()
            ->createQuery(
                'SELECT e FROM '.$this->entity.' e
                WHERE e.id = :id'
            )
            ->setParameter('id', $id)
            ->getResult();
        return $entities[0];
    }
}

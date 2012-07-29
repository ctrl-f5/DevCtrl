<?php

namespace DevCtrl\Service;

use \DevCtrl\Domain;

class ItemService extends \Ctrl\Service\AbstractDomainEntityService
{
    protected $entity = 'DevCtrl\Domain\Item\Item';

    public function test()
    {
        $item = $this->getEntityManager()->createQuery(
            'SELECT it FROM DevCtrl\Domain\Item\Item it WHERE it.id = :id'
        )->setParameter('id', 1)->getResult();
        /** @var $item \DevCtrl\Domain\Item\Item */
        $item = $item[0];

        $out = array();
        /** @var $p \DevCtrl\Domain\Item\ItemTypeProperty */
        foreach ($item->getItemType()->getItemTypeProperties() as $p) {
            $out[] = $p->getProperty()->getName();


            $propValue = new \DevCtrl\Domain\Item\ItemPropertyValue();
            $propValue->setProperty($p->getProperty())
                ->setItem($item)
                ->setValue('testvalue');

            $item->addPropertyValue($propValue);
        }

        $this->getEntityManager()->persist($item);
        $this->getEntityManager()->flush();

        return $out;

        $property = $this->getEntityManager()->createQuery(
            'SELECT it FROM DevCtrl\Domain\Item\Item it WHERE it.id = :id'
        )->setParameter('id', 1)->getResult();
        /** @var $property \DevCtrl\Domain\Item\Property */
        $property = $property[0];

        $propValue = new \DevCtrl\Domain\Item\ItemPropertyValue();
        $propValue->setProperty($property);
    }

    public function createItem()
    {
        $item = new \DevCtrl\Domain\Item\Item();
        /** @var $itemTypeService ItemTypeService */
        $itemTypeService = $this->getDomainService('ItemType');
        $type = $itemTypeService->getById(1);
        $item->setItemType($type);
        return $item->getPropertyValues();
    }
}

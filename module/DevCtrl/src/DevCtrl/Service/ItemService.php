<?php

namespace DevCtrl\Service;

use \DevCtrl\Domain;
use \DevCtrl\Domain\Item\Item;
use \DevCtrl\Domain\Item\PropertyValue;
use \DevCtrl\Domain\Item\Type\Type;

class ItemService extends \Ctrl\Service\AbstractDomainModelService
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

    /**
     * @param string $title
     * @param Domain\User $createdBy
     * @param Domain\Project $project
     * @param Type $itemType
     * @param array $propertyValues
     * @return Item
     */
    public function createItem($title, Domain\User $createdBy, Domain\Project $project, Type $itemType, $propertyValues)
    {
        $propVals = array();
        foreach ($itemType->getTypeProperties() as $itp) {
            foreach ($propertyValues as $id => $value) {
                if ($itp->getProperty()->getId() == $id) {
                    $propVal = new PropertyValue();
                    $propVal->setProperty($itp->getProperty())
                        ->setValue($value);
                    $propVals[] = $propVal;
                    break;
                }
            }
        }
        $item = new Item($title, $createdBy, $project, $itemType, $propVals);
        return $item;
    }
}

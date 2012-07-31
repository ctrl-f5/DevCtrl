<?php

namespace DevCtrl\Domain\Item\Property;

use DevCtrl\Domain\Item\Property;
use DevCtrl\Domain\Item\Item;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\ORM\EntityManager;

class CustomPossibleValuesProvider implements
    PossibleValuesProviderInterface,
    ServiceLocatorAwareInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    public function getPossibleValues(Property $property, Item $item = null)
    {
        $values = array();
        foreach ($property->getCustomPossibleValues() as $v) {
            $value = new PossibleValue();
            $value->setId($v->getId())->setValue($v->getValue());
            $values[] = $v;
        }
        return $values;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return CustomPossibleValuesProvider
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    /**
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
}

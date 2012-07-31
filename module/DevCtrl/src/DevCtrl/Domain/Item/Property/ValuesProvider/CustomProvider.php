<?php

namespace DevCtrl\Domain\Item\Property\ValuesProvider;

use DevCtrl\Domain\Item\Item;
use DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\Property\Value\Value;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\ORM\EntityManager;

class CustomProvider implements
    ProviderInterface,
    ServiceLocatorAwareInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    public function getValues(Property $property, Item $item = null)
    {
        $values = array();
        foreach ($property->getCustomValues() as $v) {
            $value = new Value();
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

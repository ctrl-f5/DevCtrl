<?php

namespace DevCtrl\EntityManager;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DevCtrl\Domain\Item\Type\TypeProperty;
use DevCtrl\Domain\Item\Property\DefaultProvider\ProviderInterface as DefaultProvider;

class ProviderToStringSubscriber implements EventSubscriber, ServiceLocatorAwareInterface
{
    protected $serviceLocator;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->setServiceLocator($serviceLocator);
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    function getSubscribedEvents()
    {
        return array(Events::postLoad);
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $e = $args->getEntity();
        if ($e instanceof TypeProperty) {
            $reflection = new \ReflectionClass($e);
            $prop = $reflection->getProperty('defaultProvider');
            $prop->setAccessible(true);
            $val = $prop->getValue($e);
            if ($val instanceof DefaultProvider) $prop->setValue($e, $val->getName());
        }
    }
}
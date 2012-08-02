<?php

namespace DevCtrl\Domain\Item\Property\Type;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\Config;
use Zend\EventManager\EventManagerAwareInterface;
use Ctrl\ServiceManager\EntityManagerAwareInterface;

class TypeLoaderFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface|ServiceManager $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $key = \DevCtrl\Module::ITEM_PROP_TYPES;
        $config = $serviceLocator->get('Configuration');
        $serviceConfig = new Config(
            isset($config[$key]) ? array('invokables' => $config[$key]) : array()
        );

        $typeLoader = new ServiceManager($serviceConfig);
        $serviceLocator->addPeeringServiceManager($typeLoader);

        return $typeLoader;
    }
}

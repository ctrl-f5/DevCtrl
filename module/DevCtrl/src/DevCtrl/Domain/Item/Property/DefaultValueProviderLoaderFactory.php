<?php

namespace DevCtrl\Domain\Item\Property;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\Config;
use Zend\EventManager\EventManagerAwareInterface;
use Ctrl\ServiceManager\EntityManagerAwareInterface;

class DefaultValueProviderLoaderFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface|ServiceManager $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $key = \DevCtrl\Module::ITEM_PROP_DEFAULT_VALUE_PROVIDERS;
        $config = $serviceLocator->get('Configuration');
        $serviceConfig = new Config(
            isset($config[$key]) ? array('invokables' => $config[$key]) : array()
        );

        $providerFactory = new ServiceManager($serviceConfig);
        $serviceLocator->addPeeringServiceManager($providerFactory);

        $providerFactory->addInitializer(function ($instance) use ($serviceLocator) {
            if ($instance instanceof ServiceLocatorAwareInterface)
                $instance->setServiceLocator($serviceLocator->get('Zend\ServiceManager\ServiceLocatorInterface'));
        });

        return $providerFactory;
    }
}

<?php

namespace DevCtrl;

use Zend\Mvc\ModuleRouteListener;
use Ctrl\EntityManager\PostLoadSubscriber;
use DevCtrl\EntityManager\ProviderToStringSubscriber;

class Module
{
    const ITEM_PROP_DEFAULT_PROVIDERS = 'domain_item_property_default_providers';
    const ITEM_PROP_VALUES_PROVIDERS = 'domain_item_property_values_providers';
    const ITEM_PROP_TYPES = 'domain_item_property_types';

    /**
     * @param $e \Zend\Mvc\MvcEvent
     */
    public function onBootstrap($e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        /** @var $entityManager \Doctrine\ORM\EntityManager */
        $entityManager = $e->getApplication()->getServiceManager()->get('doctrine.entitymanager.orm_default');
        $entityManager->getEventManager()->addEventListener(
            array(\Doctrine\ORM\Events::postLoad),
            new PostLoadSubscriber($e->getApplication()->getServiceManager())
        );
        $entityManager->getEventManager()->addEventListener(
            array(\Doctrine\ORM\Events::prePersist),
            new ProviderToStringSubscriber($e->getApplication()->getServiceManager())
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}

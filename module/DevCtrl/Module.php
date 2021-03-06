<?php

namespace DevCtrl;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\EventManager\EventManager;
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
        /** @var $eventManager EventManager */
        $eventManager           = $e->getApplication()->getEventManager();
        $serviceManager         = $e->getApplication()->getServiceManager();
        $moduleRouteListener    = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $this->initDoctrine($serviceManager);
        $this->setViewHelpers($serviceManager);
        $this->initLayout($serviceManager, $eventManager);
    }

    protected function setViewHelpers(ServiceLocatorInterface $serviceManager)
    {
        /** @var $viewManager \Zend\Mvc\View\Http\ViewManager */
        $viewManager = $serviceManager->get('ViewManager');
        if (method_exists($viewManager, 'getHelperManager')) {
            $viewManager->getHelperManager()
                ->setInvokableClass('ItemState', 'DevCtrl\View\Helper\ItemState');
        }
    }

    protected function initDoctrine(ServiceLocatorInterface $serviceManager)
    {
        /** @var $entityManager \Doctrine\ORM\EntityManager */
        $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        $entityManager->getEventManager()->addEventListener(
            array(\Doctrine\ORM\Events::postLoad),
            new PostLoadSubscriber($serviceManager)
        );
        $entityManager->getEventManager()->addEventListener(
            array(\Doctrine\ORM\Events::prePersist),
            new ProviderToStringSubscriber($serviceManager)
        );
    }

    protected function initLayout(ServiceLocatorInterface $serviceManager, EventManager $eventManager)
    {
        //feed the flashMessenger vars into the layout
        $eventManager->attach(\Zend\Mvc\MvcEvent::EVENT_RENDER, function ($e) {
            $serviceManager = $e->getApplication()->getServiceManager();
            $view = $e->getViewModel();
            if ($view->getTemplate() == 'layout/layout') {
                /**
                 * add flash messages
                 */
                /** @var $flashMessenger \Zend\Mvc\Controller\Plugin\FlashMessenger */
                $flashMessenger = $serviceManager->get('ControllerPluginManager')->get('flashMessenger');
                $messages = array();
                foreach (array('error', 'success', 'info') as $ns) {
                    if ($flashMessenger->setNamespace($ns)->hasMessages()) {
                        $messages[$ns] = $flashMessenger->getMessages();
                    }
                }
                $view->appMessages = $messages;

                /**
                 * add user
                 */
                $view->appCurrentUser = $serviceManager->get('DomainServiceLoader')->get('User')->getCurrentUser();
            }
        });
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

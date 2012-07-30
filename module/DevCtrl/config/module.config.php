<?php

namespace DevCtrl;

return array(
    'router' => array(
        'routes' => array(
            'default' => array(
                'type'    => 'Segment',
                'may_terminate' => true,
                'options' => array(
                    'route'    => '/[:controller]/[:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'DevCtrl\Controller',
                        'controller'    => 'project',
                        'action'        => 'index',
                        'id'            => false
                    ),
                ),
                'child_routes' => array(
                    'id' => array(
                        'type'    => 'Segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route'    => '/[:id]',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                        ),
                        'child_routes' => array(
                            'query' => array(
                                'type'    => 'Query',
                                'may_terminate' => true,
                            ),
                        ),
                    ),
                    'query' => array(
                        'type'    => 'Query',
                        'may_terminate' => true,
                    ),
                ),
            ),
            'item_create' => array(
                'type'    => 'Segment',
                'may_terminate' => true,
                'options' => array(
                    'route'    => '/item/create/[:project]/[:item-type]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'project'     => '[0-9]+',
                        'item-type'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'DevCtrl\Controller',
                        'controller'    => 'item',
                        'action'        => 'create',
                    ),
                ),
            ),
            'home' => array(
                'type'    => 'Segment',
                'may_terminate' => true,
                'options' => array(
                    'route'    => '/',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'project'     => '[0-9]+',
                        'item-type'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'DevCtrl\Controller',
                        'controller'    => 'project',
                        'action'        => 'index',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'DevCtrl\Controller\Index' => 'DevCtrl\Controller\IndexController',
            'DevCtrl\Controller\Project' => 'DevCtrl\Controller\ProjectController',
            'DevCtrl\Controller\Item' => 'DevCtrl\Controller\ItemController',
        ),
    ),
    'domain_services' => array(
        'invokables' => array(
            'Project' => 'DevCtrl\Service\ProjectService',
            'Item' => 'DevCtrl\Service\ItemService',
            'ItemType' => 'DevCtrl\Service\ItemTypeService',
            'User' => 'DevCtrl\Service\UserService',
        ),
    ),
    'service_manager' => array(
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'     => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'         => __DIR__ . '/../view/error/404.phtml',
            'error/index'         => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'dev-ctrl_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                    'cache' => 'array',
                    'paths' => array(__DIR__.'/../src/'.__NAMESPACE__.'/Domain', __DIR__.'/entities')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'DevCtrl\Domain' => 'dev-ctrl_driver'
                )
            )
        ),
    )
);

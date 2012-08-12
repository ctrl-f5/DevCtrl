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
                        'controller'    => 'index',
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
            'property_create' => array(
                'type'    => 'Segment',
                'may_terminate' => true,
                'options' => array(
                    'route'    => '/property/create/[:type]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'DevCtrl\Controller',
                        'controller'    => 'property',
                        'action'        => 'create',
                    ),
                ),
            ),
            'value_list_create' => array(
                'type'    => 'Segment',
                'may_terminate' => true,
                'options' => array(
                    'route'    => '/value-list/create/[:type]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'DevCtrl\Controller',
                        'controller'    => 'value-list',
                        'action'        => 'create',
                    ),
                ),
            ),
            'type_property_link' => array(
                'type'    => 'Segment',
                'may_terminate' => true,
                'options' => array(
                    'route'    => '/item-type/link-property/[:type]/[:property][/[:page]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'DevCtrl\Controller',
                        'controller'    => 'item-type',
                        'action'        => 'link-property',
                        'page'        => 1,
                    ),
                ),
            ),
            'item_create' => array(
                'type'    => 'Segment',
                'may_terminate' => true,
                'options' => array(
                    'route'    => '/item/create/[:type]/[:project]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'type'     => '[0-9]+',
                        'project'     => '[0-9]+',
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
            'DevCtrl\Controller\Milestone' => 'DevCtrl\Controller\MilestoneController',
            'DevCtrl\Controller\Item' => 'DevCtrl\Controller\ItemController',
            'DevCtrl\Controller\ItemType' => 'DevCtrl\Controller\ItemTypeController',
            'DevCtrl\Controller\Property' => 'DevCtrl\Controller\PropertyController',
            'DevCtrl\Controller\ValueList' => 'DevCtrl\Controller\ValueListController',
            'DevCtrl\Controller\StateList' => 'DevCtrl\Controller\StateListController',
        ),
    ),
    'domain_services' => array(
        'invokables' => array(
            'Project' => 'DevCtrl\Service\ProjectService',
            'Version' => 'DevCtrl\Service\VersionService',
            'Milestone' => 'DevCtrl\Service\MilestoneService',
            'Item' => 'DevCtrl\Service\ItemService',
            'ItemType' => 'DevCtrl\Service\ItemTypeService',
            'ItemTypeProperty' => 'DevCtrl\Service\ItemTypePropertyService',
            'Property' => 'DevCtrl\Service\PropertyService',
            'ValueList' => 'DevCtrl\Service\ValueListService',
            'ListValue' => 'DevCtrl\Service\ListValueService',
            'Value' => 'DevCtrl\Service\ValueService',
            'StateList' => 'DevCtrl\Service\StateListService',
            'State' => 'DevCtrl\Service\StateService',
            'ItemProperty' => 'DevCtrl\Service\ItemPropertyService',
            'User' => 'DevCtrl\Service\UserService',
        ),
    ),
    Module::ITEM_PROP_DEFAULT_PROVIDERS => array(
        'Empty'         => 'DevCtrl\Domain\Item\Property\DefaultProvider\EmptyProvider',
        'Defined'         => 'DevCtrl\Domain\Item\Property\DefaultProvider\DefinedProvider',
        'First'         => 'DevCtrl\Domain\Item\Property\DefaultProvider\FirstProvider',
        'Last'          => 'DevCtrl\Domain\Item\Property\DefaultProvider\LastProvider',
    ),
    Module::ITEM_PROP_VALUES_PROVIDERS => array(
        'CustomList'            => 'DevCtrl\Domain\Item\Property\ValuesProvider\CustomListProvider',
    ),
    Module::ITEM_PROP_TYPES => array(
        'string' => 'DevCtrl\Domain\Item\Property\Type\StringType',
        'select' => 'DevCtrl\Domain\Item\Property\Type\SelectType',
    ),
    'service_manager' => array(
        'factories' => array(
            'PropertyTypeLoader'        => 'DevCtrl\Domain\Item\Property\Type\TypeLoaderFactory',
            'ValuesProviderLoader'      => 'DevCtrl\Domain\Item\Property\ValuesProvider\ProviderLoaderFactory',
            'DefaultProviderLoader'     => 'DevCtrl\Domain\Item\Property\DefaultProvider\ProviderLoaderFactory',
        ),
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
            'error/index'         => __DIR__ . '/../view/error/index.phtml',
            'dev-ctrl/custom-error'     => __DIR__ . '/../view/dev-ctrl/error/custom-error.phtml',
            'dev-ctrl/item-widget-row'  => __DIR__ . '/../view/dev-ctrl/item/partial/widget-row.phtml',
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

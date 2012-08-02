<?php

namespace DevCtrl\Domain\Item\Property\ValuesProvider;

use DevCtrl\Domain\Item\Type\Type;
use DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\Property\Value\Value;
use Doctrine\ORM\EntityManager;
use DevCtrl\Service\ValueListService;
use DevCtrl\Domain\Item\Property\Value\ValueList;

class CustomListProvider extends AbstractServiceLocatorAwareProvider
{
    public function getName()
    {
        return 'CustomList';
    }

    public function supportsDefaultValue()
    {
        return true;
    }

    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    protected function _getValues(Property $property, $config = null)
    {
        /** @var $service ValueListService */
        $service = $this->getServiceLocator()
            ->get('DomainServiceLoader')
            ->get('ValueList');
        /** @var $list ValueList */
        $list = $service->getById($config);

        $values = array();
        foreach ($list->getValues() as $v) {
            $values[$v->getId()] = $v->getValue();
        }
        return $values;
    }

    public function requiresConfiguration()
    {
        return true;
    }

    public function _getConfigurationValues()
    {
        /** @var $service ValueListService */
        $service = $this->getServiceLocator()
            ->get('DomainServiceLoader')
            ->get('ValueList');
        /** @var $lists ValueList[] */
        $lists = $service->getAll();

        $config = array();
        foreach ($lists as $l) {
            $config[$l->getId()] = $l->getName();
        }
        return $config;
    }
}

<?php

namespace DevCtrl\Controller;

use DevCtrl\Domain;
use DevCtrl\Service\ProjectService;
use Ctrl\Controller\AbstractController as Controller;
use Zend\View\Model\ViewModel;
use DevCtrl\Domain\Item\Property\Type\TypeInterface;
use DevCtrl\Domain\Item\Property\Value\Value;
use DevCtrl\Domain\Exception;
use DevCtrl\Domain\Item\Property\Value\NativeValueInterface;

abstract class AbstractController extends Controller
{
    public function getPropertyType($typeName)
    {
        $loader = $this->getServiceLocator()->get('PropertyTypeLoader');
        return $loader->get($typeName);
    }

    public function getConfiguredPropertyTypes()
    {
        $config = $this->getServiceLocator()->get('Configuration');
        $k = \DevCtrl\Module::ITEM_PROP_TYPES;
        if (isset($config[$k])) {
            $types = array();
            foreach ($config[$k] as $k => $v) {
                $types[$k] = $this->getPropertyType($k);
            }
            return $types;
        }
        return array();
    }

    public function getNativeValueTypes()
    {
        $types = array();
        foreach (Value::getNativeValueTypes() as $k => $d) {
            if (class_exists($d['class'])) {
                $types[$k] = new $d['class'];
            }
        }
        return $types;
    }

    /**
     * @param $typeName
     * @return NativeValueInterface
     * @throws \DevCtrl\Domain\Exception
     */
    public function getNativeValueType($typeName)
    {
        $types = $this->getNativeValueTypes();
        if (isset($types[$typeName]))
            return $types[$typeName];

        throw new Exception('native type not found: '.$typeName);
    }
}

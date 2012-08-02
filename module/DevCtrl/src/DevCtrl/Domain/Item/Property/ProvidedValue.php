<?php

namespace DevCtrl\Domain\Item\Property;

use Zend\ServiceManager\ServiceLocatorInterface;
use Ctrl\Domain\ServiceLocatorAwareModel;
use DevCtrl\Domain\Item\Type\TypeProperty;
use DevCtrl\Domain\Item\Property\Value\Value;

class ProvidedValue
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var TypeProperty
     */
    protected $itemTypeProperty;

    /**
     * @var Value
     */
    protected $value;

    /**
     * @var int
     */
    protected $order;
}

<?php

namespace DevCtrl\Domain\Item\Type;

use DevCtrl\Domain\Item\Property\Property;
use Ctrl\Domain\PersistableServiceLocatorAwareModel;
use Zend\ServiceManager\ServiceLocatorInterface;
use DevCtrl\Domain\Item\Type\Type;
use DevCtrl\Domain\Item\Property\DefaultProvider\ProviderInterface;
use DevCtrl\Domain\Exception;

class TypeProperty extends PersistableServiceLocatorAwareModel
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Type
     */
    protected $itemType;

    /**
     * @var Property
     */
    protected $property;

    /**
     * @var bool
     */
    protected $required = false;

    /**
     * @var string
     */
    protected $defaultProvider = 'Empty';

    /**
     * @var string|null
     */
    protected $defaultProviderConfig;

    /**
     * @var int
     */
    protected $order;

    public function __construct(ServiceLocatorInterface $serviceLocator, Property $property, $defaultProvider)
    {
        $this->setServiceLocator($serviceLocator);
        $this->setDefaultProvider($defaultProvider);
        $this->property = $property;
    }

    /**
     * @param Property $property
     * @return TypeProperty
     */
    public function setProperty($property)
    {
        $this->property = $property;
        return $this;
    }

    /**
     * @return Property
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param boolean $required
     * @return TypeProperty
     */
    public function setRequired($required)
    {
        $this->required = (bool)$required;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getRequired()
    {
        return (bool)$this->required;
    }

    /**
     * @param \DevCtrl\Domain\Item\Type\Type $itemType
     * @return TypeProperty
     */
    public function setItemType($itemType)
    {
        $this->itemType = $itemType;
        return $this;
    }

    /**
     * @return \DevCtrl\Domain\Item\Type\Type
     */
    public function getItemType()
    {
        return $this->itemType;
    }

    /**
     * @return ProviderInterface
     */
    public function getDefaultProvider()
    {
        if (is_string($this->defaultProvider)) {
            $this->setDefaultProvider($this->defaultProvider);
        }
        return $this->defaultProvider;
    }

    /**
     * @return TypeProperty
     */
    protected function setDefaultProvider($defaultProvider)
    {
        if (is_string($defaultProvider)) {
            $this->defaultProvider = $this->getServiceLocator()
                ->get('DefaultProviderLoader')
                ->get($defaultProvider);
        } else if (is_object($defaultProvider) && $defaultProvider instanceof ProviderInterface) {
            $this->defaultProvider = $defaultProvider;
        }
        return $this;
    }

    public function setDefaultProviderConfig($defaultProviderConfig)
    {
        if ($defaultProviderConfig == null && $this->getDefaultProvider()->requiresConfiguration()) {
            throw new Exception('configuration for linked DefaultProvider cannot be empty');
        }
        $this->defaultProviderConfig = $defaultProviderConfig;
        return $this;
    }

    public function getDefaultProviderConfig()
    {
        return $this->defaultProviderConfig;
    }

    /**
     * @param int $order
     * @return TypeProperty
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }
}

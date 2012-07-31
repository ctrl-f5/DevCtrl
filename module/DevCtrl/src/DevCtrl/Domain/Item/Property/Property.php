<?php

namespace DevCtrl\Domain\Item\Property;

use Zend\ServiceManager\ServiceLocatorInterface;
use Ctrl\Domain\ServiceLocatorAwareModel;
use DevCtrl\Domain\Item\Property\DefaultProvider\ProviderInterface as DefaultProvider;
use DevCtrl\Domain\Item\Property\ValuesProvider\ProviderInterface as ValuesProvider;
use DevCtrl\Domain\Item\Property\Value\Value;
use DevCtrl\Domain\Item\Property\Value\CustomValue;
use DevCtrl\Domain\Item\Item;

class Property extends ServiceLocatorAwareModel
{
    const TYPE_SINGLE           = 'single';
    const TYPE_BOOL             = 'boolean';
    const TYPE_LIST             = 'list';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var mixed
     */
    protected $staticDefaultValue;

    /**
     * @var string
     */
    protected $defaultValueProvider = 'Empty';

    /**
     * @var string
     */
    protected $valuesProvider = 'Empty';

    /**
     * @var \DevCtrl\Domain\Collection|\DevCtrl\Domain\Item\Property\Value\CustomValue[]
     */
    protected $customValues;

    /**
     * @var string
     */
    protected $type;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->customValues = new \DevCtrl\Domain\Collection();
        $this->setServiceLocator($serviceLocator);
    }

    /**
     * @param mixed $defaultValue
     * @return Property
     */
    public function setStaticDefaultValue($defaultValue)
    {
        $this->staticDefaultValue = $defaultValue;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStaticDefaultValue()
    {
        return $this->staticDefaultValue;
    }

    /**
     * @param string $description
     * @return Property
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param int $id
     * @return Property
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     * @return Property
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDefaultValueProvider()
    {
        return $this->defaultValueProvider;
    }

    /**
     * @param $provider
     */
    public function setDefaultValueProvider($provider)
    {
        $this->defaultValueProvider = $provider;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        /** @var $provider DefaultProvider */
        $provider = $this->getServiceLocator()
            ->get('PropertyDefaultProviderLoader')
            ->get($this->defaultValueProvider);

        return $provider->getDefaultValue($this);
    }

    /**
     * @param Item $item
     * @return Value[]
     */
    public function getPossibleValues(Item $item = null)
    {
        /** @var $provider ValuesProvider */
        $provider = $this->getServiceLocator()
            ->get('PropertyValuesProviderLoader')
            ->get($this->valuesProvider);

        return $provider->getValues($this, $item);
    }

    /**
     * @param $possibleValuesProvider
     * @return Property
     */
    public function setValuesProvider($possibleValuesProvider)
    {
        $this->valuesProvider = $possibleValuesProvider;
        return $this;
    }

    /**
     * @return string
     */
    public function getValuesProvider()
    {
        return $this->valuesProvider;
    }

    /**
     * @param string $type
     * @return Property
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $customValues
     * @return Property
     */
    public function setCustomValues($customValues)
    {
        $this->customValues = $customValues;
        return $this;
    }

    /**
     * @return \DevCtrl\Domain\Collection|CustomValue[]
     */
    public function getCustomValues()
    {
        return $this->customValues;
    }

    /**
     * @param CustomValue $value
     * @return Property
     */
    public function addCustomPossibleValue(CustomValue $value)
    {
        $value->setOrder(count($this->customValues)+1);
        $value->setProperty($this);
        $this->customValues[] = $value;

        return $this;
    }
}

<?php

namespace DevCtrl\Domain\Item;

use Zend\ServiceManager\ServiceLocatorInterface;
use Ctrl\Domain\ServiceLocatorAwareModel;
use DevCtrl\Domain\Item\Property\DefaultValueProviderInterface;
use DevCtrl\Domain\Item\Property\PossibleValuesProviderInterface;

class Property extends ServiceLocatorAwareModel
{
    const TYPE_SINGLE           = 'single';
    const TYPE_BOOL             = 'boolean';
    const TYPE_LIST             = 'list';
    const TYPE_LIST_MULTI       = 'list-multi';

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

    protected $defaultValueProvider = 'Empty';

    protected $possibleValuesProvider = 'Empty';

    /**
     * @var \DevCtrl\Domain\Collection|\DevCtrl\Domain\Item\Property\CustomPossibleValue[]
     */
    protected $customPossibleValues;

    /**
     * @var string
     */
    protected $type;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->customPossibleValues = new \DevCtrl\Domain\Collection();
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
        /** @var $provider DefaultValueProviderInterface */
        $provider = $this->getServiceLocator()
            ->get('PropertyDefaultValueProviderLoader')
            ->get($this->defaultValueProvider);

        return $provider->getDefaultValue($this);
    }

    /**
     * @param Item $item
     * @return Property\PossibleValue[]
     */
    public function getPossibleValues(Item $item = null)
    {
        /** @var $provider PossibleValuesProviderInterface */
        $provider = $this->getServiceLocator()
            ->get('PropertyPossibleValuesProviderLoader')
            ->get($this->possibleValuesProvider);

        return $provider->getPossibleValues($this, $item);
    }

    /**
     * @param $possibleValuesProvider
     * @return Property
     */
    public function setPossibleValuesProvider($possibleValuesProvider)
    {
        $this->possibleValuesProvider = $possibleValuesProvider;
        return $this;
    }

    /**
     * @return string
     */
    public function getPossibleValuesProvider()
    {
        return $this->possibleValuesProvider;
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
     * @param $customPossibleValues
     * @return Property
     */
    public function setCustomPossibleValues($customPossibleValues)
    {
        $this->customPossibleValues = $customPossibleValues;
        return $this;
    }

    /**
     * @return \DevCtrl\Domain\Collection|Property\CustomPossibleValue[]
     */
    public function getCustomPossibleValues()
    {
        return $this->customPossibleValues;
    }

    /**
     * @param Property\CustomPossibleValue $value
     * @return Property
     */
    public function addCustomPossibleValue(Property\CustomPossibleValue $value)
    {
        $value->setOrder(count($this->customPossibleValues)+1);
        $value->setProperty($this);
        $this->customPossibleValues[] = $value;

        return $this;
    }
}

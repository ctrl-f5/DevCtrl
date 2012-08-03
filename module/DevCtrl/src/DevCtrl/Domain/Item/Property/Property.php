<?php

namespace DevCtrl\Domain\Item\Property;

use Zend\ServiceManager\ServiceLocatorInterface;
use Ctrl\Domain\PersistableServiceLocatorAwareModel;
use DevCtrl\Domain\Item\Item;
use DevCtrl\Domain\Item\Property\DefaultProvider\ProviderInterface as DefaultProvider;
use DevCtrl\Domain\Item\Property\ValuesProvider\ProviderInterface as ValuesProvider;
use DevCtrl\Domain\Item\Property\Value\Value;
use DevCtrl\Domain\Item\Property\Value\CustomValue;
use DevCtrl\Domain\Item\Property\Type\TypeInterface;
use DevCtrl\Domain\Item\Type\TypeProperty;
use DevCtrl\Domain\Collection;

class Property extends PersistableServiceLocatorAwareModel
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var ValuesProvider
     */
    protected $valuesProvider;

    /**
     * @var string
     */
    protected $valuesProviderConfig;

    /**
     * @var string
     */
    protected $typeName;

    /**
     * @var TypeInterface
     */
    protected $type;

    /**
     * @var TypeProperty[]
     */
    protected $typeProperties;

    public function __construct(TypeInterface $type, $provider, $providerConfig)
    {
        $this->setType($type);
        $this->valuesProvider = $provider;
        $this->valuesProviderConfig = $providerConfig;
        $this->typeProperties = new Collection();
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
     * @param TypeInterface $type
     * @return Property
     */
    public function setType(TypeInterface $type)
    {
        $this->type = $type;
        $this->typeName = $type->getRepresentedPorpertyType();
        return $this;
    }

    /**
     * @return TypeInterface
     */
    public function getType()
    {
        return $this->getServiceLocator()
            ->get('PropertyTypeLoader')
            ->get($this->typeName);
    }

    /**
     * @return \DevCtrl\Domain\Item\Property\ValuesProvider\ProviderInterface
     */
    public function getValuesProvider()
    {
        return $this->getServiceLocator()
            ->get('ValuesProviderLoader')
            ->get($this->valuesProvider);
    }

    /**
     * @return string
     */
    public function getValuesProviderConfig()
    {
        return $this->valuesProviderConfig;
    }

    /**
     * @param $typeProperties
     * @return Property
     */
    public function setTypeProperties($typeProperties)
    {
        $this->typeProperties = $typeProperties;
        return $this;
    }

    /**
     * @return TypeProperty[]
     */
    public function getTypeProperties()
    {
        return $this->typeProperties;
    }
}
<?php

namespace DevCtrl\Domain\Item;

class Property
{
    const PROP_TYPE_SINGLE              = 1;
    const PROP_TYPE_RANGED              = 2;
    const PROP_TYPE_RESTRICTED          = 3;
    const PROP_TYPE_BOOL                = 4;
    const PROP_TYPE_MULTIPLE            = 5;
    const PROP_TYPE_SORTABLE            = 6;

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
     * @var int
     */
    protected $type = 1;

    /**
     * @param mixed $defaultValue
     * @return Property
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
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
     * @param \DevCtrl\Domain\Item\Item $item
     * @return Property
     */
    public function setItem($item)
    {
        $this->item = $item;
        return $this;
    }

    /**
     * @return \DevCtrl\Domain\Item\Item
     */
    public function getItem()
    {
        return $this->item;
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
}

<?php

namespace DevCtrl\Domain\Item\Property\Value;

use DevCtrl\Domain\Item\Property\Property;

class CustomValue
{
    /**
     * @var int
     */
    protected $id;

    /** @var Property */
    protected $property;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var int
     */
    protected $order;

    /**
     * @param int $id
     * @return PossibleValue
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
     * @param mixed $value
     * @return PossibleValue
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param int $order
     * @return PossibleValue
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

    /**
     * @param \DevCtrl\Domain\Item\Property $property
     * @return CustomPossibleValue
     */
    public function setProperty($property)
    {
        $this->property = $property;
        return $this;
    }

    /**
     * @return \DevCtrl\Domain\Item\Property
     */
    public function getProperty()
    {
        return $this->property;
    }
}

<?php

namespace DevCtrl\Domain\Item\Property;

class PossibleValue
{
    /**
     * @var int
     */
    protected $id;

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
}

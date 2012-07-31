<?php

namespace DevCtrl\Domain\Item\Property\Value;

class Value
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
     * @return Value
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
     * @return Value
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
     * @return Value
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

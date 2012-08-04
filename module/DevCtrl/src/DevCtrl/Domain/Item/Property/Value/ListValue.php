<?php

namespace DevCtrl\Domain\Item\Property\Value;

use Ctrl\Domain\PersistableModel;
use DevCtrl\Domain\Value\Value;

class ListValue extends PersistableModel
{
    /**
     * @var Value
     */
    protected $value;

    /**
     * @var ValueList
     */
    protected $list;

    /**
     * @var int
     */
    protected $order;

    /**
     * @param ValueList $list
     * @return ListValue
     */
    public function setList(ValueList $list)
    {
        $this->list = $list;
        return $this;
    }

    /**
     * @return ValueList
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * @param Value $value
     * @return ListValue
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return Value
     */
    public function getValue()
    {
        return $this->value;
    }


    /**
     * @param $order
     * @return ListValue
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

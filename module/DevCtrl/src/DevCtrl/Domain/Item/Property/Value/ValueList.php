<?php

namespace DevCtrl\Domain\Item\Property\Value;

use DevCtrl\Domain\Item\Property\Value\ListValue;
use DevCtrl\Domain\Value\Value;
use DevCtrl\Domain\Collection;

class ValueList extends \Ctrl\Domain\PersistableModel
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var ListValue[]
     */
    protected $values;

    /**
     * @var
     */
    protected $nativeType;

    public function __construct($name, $nativeType)
    {
        $this->values = new Collection;
        $this->name = $name;
        $this->nativeType = $nativeType;
    }

    /**
     * @param string $name
     * @return ValueList
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
     * @param $values
     * @return ValueList
     */
    public function setValues($values)
    {
        $this->values = $values;
        return $this;
    }

    /**
     * @return ListValue[]
     */
    public function getValues()
    {
        return $this->values;
    }

    public function addValue(Value $value)
    {
        foreach ($this->values as $v) {
            if ($v->getValue()->getId() == $value->getId())
                return $this;
        }
        $listValue = new ListValue();
        $listValue->setList($this)
            ->setValue($value)
            ->setOrder(
                count($this->values) + 1
            );
        $this->values[] = $listValue;
        return $this;
    }

    public function removeValue(Value $value)
    {
        $values = $this->values;
        $this->values = new Collection();
        foreach ($values as $v) {
            if ($v->getValue()->getId() == $value->getId()) continue;
            $this->values[] = $v;
        }
        return $this;
    }

    public function getNativeType()
    {
        return $this->nativeType;
    }
}

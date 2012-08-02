<?php

namespace DevCtrl\Domain\Item\Property\Value;

use DevCtrl\Domain\Item\Property\Value\Value;
use DevCtrl\Domain\Collection;

class ValueList extends \Ctrl\Domain\Persistable
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var Value[]
     */
    protected $values;

    /**
     * @var
     */
    protected $nativeType;

    public function __construct()
    {
        $this->values = new Collection;
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
     * @return Value[]
     */
    public function getValues()
    {
        return $this->values;
    }

    public function addValue(Value $value)
    {
        $this->values[] = $value;
        return $this;
    }

    public function getNativeType()
    {
        return $this->nativeType;
    }
}

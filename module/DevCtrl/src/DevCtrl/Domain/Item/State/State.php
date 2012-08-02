<?php

namespace DevCtrl\Domain\Item\State;

use Ctrl\Domain\Persistable;
use DevCtrl\Domain\Exception;

class State extends Persistable
{
    /**
     * @var array
     */
    protected static $nativeStates = array(
        'open',
        'blocked',
        'closed'
    );

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $color;

    /**
     * @var string
     */
    protected $nativeState;

    /**
     * @var StateList
     */
    protected $list;
    /**
     * @var int
     */
    protected $order;

    public static function getNativeStates()
    {
        return self::$nativeStates;
    }

    public function __construct($nativeState, StateList $list)
    {
        if (!in_array($nativeState, $this::getNativeStates())) {
            throw new Exception('State must have a valid native state');
        }
        $this->nativeState = $nativeState;
        $this->list = $list;
    }

    /**
     * @param string $color
     * @return State
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $label
     * @return State
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function getNativeState()
    {
        return $this->nativeState;
    }

    /**
     * @param int $order
     * @return State
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
     * @return StateList
     */
    public function setList()
    {
        return $this->list;
    }

    /**
     * @return StateList
     */
    public function getList()
    {
        return $this->list;
    }
}

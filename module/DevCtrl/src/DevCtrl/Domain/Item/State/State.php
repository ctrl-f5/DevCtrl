<?php

namespace DevCtrl\Domain\Item\State;

use Ctrl\Domain\PersistableModel;
use DevCtrl\Domain\Exception;

class State extends PersistableModel
{
    /**
     * @var array
     */
    protected static $nativeStates = array(
        1 => 'open',
        2 => 'blocked',
        3 => 'closed'
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

    public static function getNativeStates($id = null)
    {
        if ($id) {
            if (isset(self::$nativeStates[$id])) {
                return self::$nativeStates[$id];
            }
            throw new Exception('Requested unexisting native state: '.$id);
        }

        return self::$nativeStates;
    }

    public function __construct($nativeState, StateList $list, $label = null, $color = null)
    {
        if (!in_array($nativeState, $this::getNativeStates())) {
            throw new Exception('State must have a valid native state');
        }
        $this->nativeState = $nativeState;
        $this->setList($list)
            ->setLabel($label)
            ->setColor($color);
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
     * @param string $nativeState
     * @return State
     */
    protected function setNativeState($nativeState)
    {
        $this->nativeState = $nativeState;
        return $this;
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
     * @param StateList $list
     * @return State
     */
    public function setList(StateList $list)
    {
        $this->list = $list;
        return $this;
    }

    /**
     * @return StateList
     */
    public function getList()
    {
        return $this->list;
    }
}

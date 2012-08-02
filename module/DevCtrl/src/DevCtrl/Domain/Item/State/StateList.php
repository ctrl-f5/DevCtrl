<?php

namespace DevCtrl\Domain\Item\State;

use Ctrl\Domain\Persistable;
use DevCtrl\Domain\Exception;
use DevCtrl\Domain\Collection;

class StateList extends Persistable
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var State[]
     */
    protected $states;

    public function __construct()
    {
        $this->states = new Collection();
    }

    /**
     * @param string $name
     * @return StateList
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
     * @return State[]
     */
    public function getStates()
    {
        return $this->states;
    }

    /**
     * @param State $state
     * @return StateList
     */
    public function addState(State $state)
    {
        $state->setList($this);
        $state->setOrder(count($this->getStates()+1));
        $this->states[] = $state;
        return $this;
    }
}

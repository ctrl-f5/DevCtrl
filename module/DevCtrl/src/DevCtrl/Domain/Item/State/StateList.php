<?php

namespace DevCtrl\Domain\Item\State;

use Ctrl\Domain\PersistableModel;
use DevCtrl\Domain\Exception;
use DevCtrl\Domain\Collection;
use DevCtrl\Domain\Item\Type\Type;

class StateList extends PersistableModel
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var State[]
     */
    protected $states;

    /**
     * @var Type[]
     */
    protected $itemTypes;

    public function __construct()
    {
        $this->states = new Collection();
        $this->itemTypes = new Collection();
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

    public function getItemTypes()
    {
        return $this->itemTypes;
    }
}

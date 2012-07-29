<?php

namespace DevCtrl\Domain\Item;

class State
{
    const END_STATE_OPEN        = 1;
    const END_STATE_BLOCKED     = 2;
    const END_STATE_CLOSED      = 3;

    protected $id;

    protected $name;

    protected $endState;
}

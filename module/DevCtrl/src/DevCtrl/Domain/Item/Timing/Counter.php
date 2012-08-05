<?php

namespace DevCtrl\Domain\Item\Timing;

use Ctrl\Domain\PersistableModel;
use DevCtrl\Domain\Item\Item;

class Counter extends PersistableModel
{
    /**
     * @var Item
     */
    protected $item;

    /**
     * @var int
     */
    protected $estimated;

    /**
     * @var int
     */
    protected $executed;

    /**
     * @param int $estimated
     * @return Counter
     */
    public function setEstimated($estimated)
    {
        $this->estimated = $estimated;
        return $this;
    }

    /**
     * @return int
     */
    public function getEstimated()
    {
        return $this->estimated;
    }

    /**
     * @param int $executed
     * @return Counter
     */
    public function setExecuted($executed)
    {
        $this->executed = $executed;
        return $this;
    }

    /**
     * @return int
     */
    public function getExecuted()
    {
        return $this->executed;
    }

    /**
     * @param Item $item
     * @return Counter
     */
    public function setItem($item)
    {
        $this->item = $item;
        return $this;
    }

    /**
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }
}

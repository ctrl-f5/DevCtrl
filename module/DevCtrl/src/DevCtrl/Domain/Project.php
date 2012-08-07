<?php

namespace DevCtrl\Domain;

use Ctrl\Domain\PersistableModel;
use DevCtrl\Domain\Item\Item;

class Project extends PersistableModel
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var Item[]
     */
    protected $backlog;

    /**
     * @var Version[]|Collection
     */
    protected $versions;

    public function __construct()
    {
        $this->backlog = new Collection();
    }

    /**
     * @param string $name
     * @return Project
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
     * @return Item[]
     */
    public function getBacklog()
    {
        return $this->backlog;
    }

    /**
     * @param Item $item
     * @return Project
     */
    public function addToBacklog(Item $item)
    {
        $item->setProject($this);
        $this->backlog[] = $item;
        return $this;
    }

    /**
     * @return float|int
     */
    public function getProgress()
    {
        $estimated = 0;
        $executed = 0;
        foreach ($this->getBacklog() as $i) {
            if ($i->getItemType()->supportsTiming()) {
                $estimated += $i->getTimeCounter()->getEstimated();
                if ($i->getItemType()->hasStates()
                    && $i->getState()->getNativeState() == \DevCtrl\Domain\Item\State\State::STATE_CLOSED) {
                    $estimated += $i->getTimeCounter()->getEstimated();
                } else {
                    $executed += $i->getTimeCounter()->getExecuted();
                }
            }
        }
        $percent = 0;
        if ($estimated) {
            $percent = round($executed / $estimated * 100);
        }
        return $percent;
    }

    /**
     * @param string $description
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
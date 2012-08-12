<?php

namespace DevCtrl\Domain\Project;

use Ctrl\Domain\PersistableModel;
use DevCtrl\Domain\Item\Item;

class Milestone extends PersistableModel
{
    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var Project
     */
    protected $project;

    /**
     * @var Item[]
     */
    protected $backlog;

    /**
     * @var Version
     */
    protected $resultingVersion;

    /**
     * @var DateTime
     */
    protected $dateCreated;

    /**
     * @var DateTime|null
     */
    protected $dateEnd;

    /**
     * @var DateTime|null
     */
    protected $dateStart;

    public function __construct(Project $project)
    {
        $this->backlog = new \DevCtrl\Domain\Collection();
        $this->project = $project;
        $this->dateCreated = new \DateTime();
        $project->addMilestone($this);
    }

    /**
     * @param string $name
     * @return Project
     */
    public function setLabel($name)
    {
        $this->label = $name;
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
                if ($i->getItemType()->supportsStates()
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

    /**
     * @param \DevCtrl\Domain\Project\Version $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return \DevCtrl\Domain\Project\Version
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param \DevCtrl\Domain\Project\DateTime|null $dateEnd
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;
        return $this;
    }

    /**
     * @return \DevCtrl\Domain\Project\DateTime|null
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * @param \DevCtrl\Domain\Project\DateTime|null $dateStart
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;
        return $this;
    }

    /**
     * @return \DevCtrl\Domain\Project\DateTime|null
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }
}
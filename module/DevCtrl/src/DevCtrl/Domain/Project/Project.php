<?php

namespace DevCtrl\Domain\Project;

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
    protected $versionList;

    /**
     * @var Version
     */
    protected $version;

    public function __construct()
    {
        $this->backlog = new \DevCtrl\Domain\Collection();
        $this->versionList = new \DevCtrl\Domain\Collection();
        $this->version = new Version($this);
        $this->version->setVersion('0.0.0')
            ->setLabel('current');
        $this->addVersion($this->version);
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

    public function addVersion(Version $version)
    {
        $version->setOrder(count($this->getVersionList()) + 1);
        $this->versionList[] = $version;
    }

    public function getVersionList()
    {
        return $this->versionList;
    }
}
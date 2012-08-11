<?php

namespace DevCtrl\Domain\Item;

use \DevCtrl\Domain;
use \DevCtrl\Domain\Item\Item;
use \DevCtrl\Domain\Item\Type\TypeProperty;
use DevCtrl\Domain\Item\Property\Property;
use Ctrl\Domain\PersistableModel;
use DevCtrl\Domain\Value\NativeValueInterface;
use DevCtrl\Domain\Value\Value;

class ItemRelation extends PersistableModel
{
    /**
     * @var string
     */
    protected $type = '';

    /**
     * @var Item
     */
    protected $item;

    /**
     * @var Item
     */
    protected $relatedItem;

    /**
     * @var string
     */
    protected $description;

    /**
     * @param Item $item
     * @return ItemProperty
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

    /**
     * @param \DevCtrl\Domain\Item\Item $relatedItem
     */
    public function setRelatedItem($relatedItem)
    {
        $this->relatedItem = $relatedItem;
    }

    /**
     * @return \DevCtrl\Domain\Item\Item
     */
    public function getRelatedItem()
    {
        return $this->relatedItem;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}

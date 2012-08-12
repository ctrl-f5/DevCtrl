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
    const TYPE_CHILD        = 'child';
    const TYPE_PARENT       = 'parent';
    const TYPE_BLOCKING     = 'blocking';
    const TYPE_BLOCKED      = 'blocked';

    public static function getTypes()
    {
        return array(
            self::TYPE_CHILD,
            self::TYPE_PARENT,
            self::TYPE_BLOCKING,
            self::TYPE_BLOCKED,
        );
    }

    public static function getOppositeType($type)
    {
        switch ($type) {
            case self::TYPE_BLOCKED:
                return self::TYPE_BLOCKING;
                break;
            case self::TYPE_BLOCKING:
                return self::TYPE_BLOCKED;
                break;
            case self::TYPE_PARENT:
                return self::TYPE_CHILD;
                break;
            case self::TYPE_CHILD:
                return self::TYPE_PARENT;
                break;
        }
        throw new Exception('invalid relation type');
    }

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
     * @return ItemRelation
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
        return $this;
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

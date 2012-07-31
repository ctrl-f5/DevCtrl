<?php

namespace DevCtrl\Domain\Item\Property;

use DevCtrl\Domain\Item\Property;
use DevCtrl\Domain\Item\Item;

class ProjectVersionPossibleValuesProvider implements PossibleValuesProviderInterface
{
    public function getPossibleValues(Property $property, Item $item = null)
    {
        $values = array();
        foreach ($item->getProject()->getVersions() as $v) {
            $values = new PossibleValue();
            $values->setId($v->getId())->setValue($v->getName());
            $values[] = $v;
        }
        return $values;
    }
}

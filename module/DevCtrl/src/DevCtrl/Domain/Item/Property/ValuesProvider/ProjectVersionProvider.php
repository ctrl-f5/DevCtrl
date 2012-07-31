<?php

namespace DevCtrl\Domain\Item\Property\ValuesProvider;

use DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\Item;

class ProjectVersionProvider implements ProviderInterface
{
    public function getValues(Property $property, Item $item = null)
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

<?php

namespace DevCtrl\Domain\Item\Property\ValuesProvider;

use DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\Type\Type;

class ProjectPropertyProvider extends AbstractProvider
{
    public function getName()
    {
        return 'ProjectProperty';
    }

    protected function _getValues(Property $property, $config = null)
    {
        $values = array();
        return array();
        foreach ($itemType->getProject()->getVersions() as $v) {
            $values = new PossibleValue();
            $values->setId($v->getId())->setValue($v->getName());
            $values[] = $v;
        }
        return $values;
    }

    public function requiresConfiguration()
    {
        return true;
    }

    public function _getConfigurationValues()
    {
        return array(
            'project.version' => 'ProjectVersion'
        );
    }
}

<?php

namespace DevCtrl\Service;

use DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\State\StateList;
use Ctrl\Form\Form;
use Ctrl\Form\Element\Text as TextInput;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as FilterFactory;

class StateListService extends \Ctrl\Service\AbstractDomainModelService
{
    protected $entity = 'DevCtrl\Domain\Item\State\StateList';

    public function getForm(StateList $state = null)
    {
        $form = new Form('create-state-list');

        $property = new TextInput('name');
        $property->setValue($state->getName())
            ->setLabel('name');

        $factory = new FilterFactory();
        $filter = new \Zend\InputFilter\InputFilter();
        $filter->add($factory->createInput(array(
            'name'     => 'name',
            'required' => true,
        )));
        $form->setInputFilter($filter);
        $form->add($property);

        return $form;
    }

    public function canRemove(StateList $list)
    {
        if (!$this->getEntityManager()->contains($list)) {
            return false;
        }

        return count($list->getItemTypes()) == 0;
    }
}

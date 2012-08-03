<?php

namespace DevCtrl\Service;

use DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\State\State;
use Ctrl\Form\Form;
use Ctrl\Form\Element\Text as TextInput;
use Ctrl\Form\Element\Select as SelectInput;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as FilterFactory;

class StateService extends \Ctrl\Service\AbstractDomainModelService
{
    protected $entity = 'DevCtrl\Domain\Item\State\State';

    public function getForm(State $state = null)
    {
        $form = new Form('create-item-state');

        $property = new TextInput('label');
        $property->setLabel('label');
        if ($state) $property->setValue($state->getId());
        $form->add($property);

        $property = new SelectInput('native-state');
        $property->setLabel('native state')
            ->setAttribute('options', State::getNativeStates());

        if ($state) $property->setValue($state->getId());
        $form->add($property);

        $property = new TextInput('color');
        $property->setLabel('color');
        if ($state) $property->setValue($state->getId());
        $form->add($property);

        $factory = new FilterFactory();
        $filter = new \Zend\InputFilter\InputFilter();
        $filter->add($factory->createInput(array(
            'name'     => 'label',
            'required' => true,
        )))->add($factory->createInput(array(
            'name'     => 'native-state',
            'required' => true,
        )))->add($factory->createInput(array(
            'name'     => 'color',
            'required' => false,
        )));
        $form->setInputFilter($filter);

        return $form;
    }
}

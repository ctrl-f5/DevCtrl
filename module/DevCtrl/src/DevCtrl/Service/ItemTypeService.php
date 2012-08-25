<?php

namespace DevCtrl\Service;

use \DevCtrl\Domain;
use DevCtrl\Domain\Item\Type\Type;
use DevCtrl\Domain\Item\State\StateList;
use Ctrl\Form\Form;
use Ctrl\Form\Element\Text as TextInput;
use Ctrl\Form\Element\Select as SelectInput;
use Ctrl\Form\Element\Checkbox as CheckboxInput;
use Zend\InputFilter\Factory as FilterFactory;
use Zend\InputFilter\InputFilter;

class ItemTypeService extends \Ctrl\Service\AbstractDomainModelService
{
    protected $entity = 'DevCtrl\Domain\Item\Type\Type';

    public function getForm(Type $type = null)
    {
        $form = new Form('form-item-type-create');

        $input = new TextInput('name');
        $input->setLabel('name');
        if ($type) $input->setValue($type->getName());
        $form->add($input);

        $input = new TextInput('description');
        $input->setLabel('description');
        if ($type) $input->setValue($type->getDescription());
        $form->add($input);

        $input = new CheckboxInput('supports-timing');
        $input->setLabel('supports timing');
        if ($type) $input->setValue($type->supportsTiming());
        else $input->setValue(1);
        $form->add($input);

        $input = new CheckboxInput('supports-versions');
        $input->setLabel('version aware');
        if ($type) $input->setValue($type->supportsVersions());
        else $input->setValue(1);
        $form->add($input);

        $input = new SelectInput('state-list');
        $input->setLabel('state set');
        /** @var $states StateList[] */
        $states = $this->getDomainService('StateList')->getAll();
        $stateOptions = array('');//add empty first selection
        if (count($states)) {
            if ($type && $type->supportsStates()) $input->setValue($type->getStates()->getId());
            foreach ($states as $s) {
                $stateOptions[$s->getId()] = $s->getName();
            }
        }
        $input->setAttribute('options', $stateOptions);
        $form->add($input);

        $form->setInputFilter($this->getModelInputFilter());

        return $form;
    }

    public function getModelInputFilter()
    {
        $factory = new FilterFactory();
        $filter = new InputFilter();
        $filter->add($factory->createInput(array(
            'name'     => 'name',
            'required' => true,
        )))->add($factory->createInput(array(
            'name'     => 'description',
            'required' => false,
        )))->add($factory->createInput(array(
            'name'     => 'supports-timing',
            'required' => false,
        )))->add($factory->createInput(array(
            'name'     => 'supports-versions',
            'required' => false,
        )));

        return $filter;
    }
}

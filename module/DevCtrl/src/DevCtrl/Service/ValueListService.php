<?php

namespace DevCtrl\Service;

use DevCtrl\Domain\Item\Property\Value\ValueList;
use DevCtrl\Domain\Value\NativeValueInterface;
use Ctrl\Form\Element\Text as TextInput;
use Ctrl\Form\Element\Select as SelectInput;
use Ctrl\Form\Form;
use Zend\InputFilter\Factory as FilterFactory;
use Zend\InputFilter\InputFilter;

class ValueListService extends \Ctrl\Service\AbstractDomainModelService
{
    protected $entity = 'DevCtrl\Domain\Item\Property\Value\ValueList';

    public function getForm(ValueList $property = null)
    {
        throw new Exception('this method is not supported on this service, use the getForm*() functions instead');
    }

    public function getFormForType(NativeValueInterface $type, ValueList $list = null)
    {
        $form = new Form('create-value-list');

        $input = new TextInput('name');
        $input->setLabel('name');
        if ($list) $input->setValue($list->getName());
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
        )));

        return $filter;
    }

    public function canRemove(ValueList $list)
    {
        if (!$this->getEntityManager()->contains($list)) {
            return false;
        }

        return count($list->getValues()) == 0;
    }
}

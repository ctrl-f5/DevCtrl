<?php

namespace DevCtrl\Service;

use \DevCtrl\Domain;
use \DevCtrl\Domain\Item\Item;
use \DevCtrl\Domain\Item\Type\Type;
use DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\Property\Type\TypeInterface;
use Zend\InputFilter\Factory as FilterFactory;
use Zend\InputFilter\InputFilter;
use DevCtrl\Domain\Item\Property\ValuesProvider\ProviderInterface as ValuesProvider;
use Ctrl\Form\Form;
use Ctrl\Form\Element\Text as TextInput;
use Ctrl\Form\Element\Select as SelectInput;

class ItemService extends \Ctrl\Service\AbstractDomainModelService
{
    protected $entity = 'DevCtrl\Domain\Item\Item';

    public function getForm(Item $item = null)
    {
        throw new Exception('this method is not supported on this service, use the getFormForType() function instead');
    }

    public function getFormForType(Type $type, Item $item = null)
    {
        $form = new Form('form-item-create');

        $input = new TextInput('title');
        $input->setLabel('title');
        if ($item) $input->setValue($item->getTitle());
        $form->add($input);

        $input = new TextInput('description');
        $input->setLabel('description');
        if ($item) $input->setValue($item->getDescription());
        $form->add($input);

        if ($type->supportsTiming() && $item->getTimeCounter()) {
            $input = new TextInput('timing-estimated');
            $input->setLabel('estimated time');
            if ($item) $input->setValue($item->getTimeCounter()->getEstimated());
            $form->add($input);

            $input = new TextInput('timing-executed');
            $input->setLabel('executed time');
            if ($item) $input->setValue($item->getTimeCounter()->getExecuted());
            else $input->setValue(0);
            $form->add($input);
        }

        if ($type->hasStates()) {
            $states = array();
            $input = new SelectInput();
            $input->setLabel('state')->setName('state');
            foreach ($type->getStates()->getStates() as $s) {
                $states[$s->getId()] = $s->getLabel();
            }
            $input->setAttribute('options', $states);
            if ($item) $input->setValue($item->getState()->getId());
            $form->add($input);
        }

        foreach ($type->getTypeProperties() as $tp) {

            $input = false;
            switch ($tp->getProperty()->getType()->getRepresentedPorpertyType()) {
                case 'string':
                    $input = new TextInput('property-'.$tp->getId());
                    $input->setLabel($tp->getProperty()->getName());
                    $form->add($input);
                    break;
                case 'select':
                    $input = new SelectInput();
                    $input->setName('property-'.$tp->getId())
                        ->setLabel($tp->getProperty()->getName());
                    $input->setAttribute(
                        'options',
                        $tp->getProperty()->getValuesProvider()->getValues($tp->getProperty())
                    );
                    $form->add($input);
                    break;
            }

            if ($item && $input) {
                $input->setValue(
                    $item->getItemProperty(
                        $tp->getProperty()
                    )->getValue()->getValue()
                );
            } else {
                if ($tp->getProperty()->getType()->supportsDefaultValue() && $tp->getDefaultProvider()) {
                    $input->setValue(
                        $tp->getDefaultProvider()->getDefaultValue(
                            $tp
                        )
                    );
                }
            }
        }

        $form->setInputFilter($this->getModelInputFilter($type));

        return $form;
    }


    protected function getModelInputFilter(Type $type)
    {
        $factory = new FilterFactory();
        $filter = new InputFilter();
        $filter->add($factory->createInput(array(
            'name'     => 'title',
            'required' => true,
        )))->add($factory->createInput(array(
            'name'     => 'description',
            'required' => false,
        )))->add($factory->createInput(array(
            'name'     => 'type',
            'required' => false,
        )));

        if ($type->supportsTiming()) {
            $filter->add($factory->createInput(array(
                'name'     => 'timing-estimated',
                'required' => true,
            )));

            $filter->add($factory->createInput(array(
                'name'     => 'timing-executed',
                'required' => true,
            )));
        }

        if ($type->hasStates()) {
            $filter->add($factory->createInput(array(
                'name'     => 'state',
                'required' => true,
            )));
        }

        foreach ($type->getTypeProperties() as $tp) {
            $filter->add($factory->createInput(array(
                'name'     => 'property-'.$tp->getId(),
                'required' => true,
            )));
        }

        return $filter;
    }
}

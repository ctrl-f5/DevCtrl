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

        if (false && $type->supportsTiming()) {
            //TODO: add timing
            $input = new TextInput('timing-estimated');
            $input->setLabel('estimated required time');
            //if ($item) $input->setValue($item->get());
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

        foreach ($type->getTypeProperties() as $tp) {
            $filter->add($factory->createInput(array(
                'name'     => 'property-'.$tp->getId(),
                'required' => true,
            )));
        }

        return $filter;
    }
}

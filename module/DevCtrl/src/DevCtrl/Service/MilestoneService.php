<?php

namespace DevCtrl\Service;

use \DevCtrl\Domain;
use DevCtrl\Domain\Project\Project;
use DevCtrl\Domain\Item\Item;
use Zend\InputFilter\Factory as FilterFactory;
use Zend\InputFilter\InputFilter;
use DevCtrl\Domain\Item\Property\ValuesProvider\ProviderInterface as ValuesProvider;
use Ctrl\Form\Form;
use Ctrl\Form\Element\Text as TextInput;
use Ctrl\Form\Element\Textarea as TextareaInput;

class MilestoneService extends \Ctrl\Service\AbstractDomainModelService
{
    protected $entity = 'DevCtrl\Domain\Project\Milestone';

    public function getForm(Project $version = null)
    {
        $form = new Form('form-project');

        $input = new TextInput('name');
        $input->setLabel('name');
        if ($version) $input->setValue($version->getName());
        $form->add($input);

        $input = new TextareaInput('description');
        $input->setLabel('description');
        if ($version) $input->setValue($version->getDescription());
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
        )));

        return $filter;
    }
}

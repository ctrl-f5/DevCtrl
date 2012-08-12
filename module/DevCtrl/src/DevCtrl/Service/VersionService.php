<?php

namespace DevCtrl\Service;

use \DevCtrl\Domain;
use DevCtrl\Domain\Project\Project;
use DevCtrl\Domain\Project\Version;
use Zend\InputFilter\Factory as FilterFactory;
use Zend\InputFilter\InputFilter;
use DevCtrl\Domain\Item\Property\ValuesProvider\ProviderInterface as ValuesProvider;
use Ctrl\Form\Form;
use Ctrl\Form\Element\Text as TextInput;
use Ctrl\Form\Element\Textarea as TextareaInput;

class VersionService extends \Ctrl\Service\AbstractDomainModelService
{
    protected $entity = 'DevCtrl\Domain\Project\Version';

    public function getForm(Version $version = null)
    {
        $form = new Form('form-project-version');

        $input = new TextInput('version');
        $input->setLabel('version');
        if ($version) $input->setValue($version->getVersion());
        $form->add($input);

        $input = new TextInput('label');
        $input->setLabel('label');
        if ($version) $input->setValue($version->getLabel());
        $form->add($input);

        $input = new TextInput('description');
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
            'name'     => 'version',
            'required' => true,
        )))->add($factory->createInput(array(
            'name'     => 'label',
            'required' => true,
        )))->add($factory->createInput(array(
            'name'     => 'description',
            'required' => false,
        )));

        return $filter;
    }
}

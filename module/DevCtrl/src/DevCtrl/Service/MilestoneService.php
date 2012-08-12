<?php

namespace DevCtrl\Service;

use \DevCtrl\Domain;
use DevCtrl\Domain\Project\Milestone;
use DevCtrl\Domain\Project\Project;
use DevCtrl\Domain\Item\Item;
use Zend\InputFilter\Factory as FilterFactory;
use Zend\InputFilter\InputFilter;
use DevCtrl\Domain\Item\Property\ValuesProvider\ProviderInterface as ValuesProvider;
use Ctrl\Form\Form;
use Ctrl\Form\Element\Text as TextInput;
use Ctrl\Form\Element\Textarea as TextareaInput;
use Ctrl\Form\Element\Select as SelectInput;

class MilestoneService extends \Ctrl\Service\AbstractDomainModelService
{
    protected $entity = 'DevCtrl\Domain\Project\Milestone';

    public function getForm($context = null)
    {
        /** @var $milestone Milestone */
        $milestone = ($context instanceof Milestone) ? $context: null;
        /** @var $project Project */
        if ($milestone) $project = $milestone->getProject();
        else $project = ($context instanceof Project) ? $context: null;

        $form = new Form('form-milestone');

        $input = new TextInput('label');
        $input->setLabel('label');
        if ($milestone) $input->setValue($milestone->getLabel());
        $form->add($input);

        $input = new TextareaInput('description');
        $input->setLabel('description');
        if ($milestone) $input->setValue($milestone->getDescription());
        $form->add($input);

        $input = new SelectInput();
        $input->setLabel('version')->setName('version');
        $versions = array('');//add empty option, since not required
        if ($project && $project->getVersionList()) {
            foreach ($project->getVersionList() as $v) {
                $versions[$v->getId()] = $v->getVersion().' '.$v->getLabel();
            }
        }
        $input->setAttribute('options', $versions);
        if ($milestone && $milestone->getResultingVersion()) $input->setValue($milestone->getResultingVersion()->getId());
        $form->add($input);

        $input = new TextInput('date-start');
        $input->setLabel('date-start');
        if ($milestone && $milestone->getDateStart()) $input->setValue($milestone->getDateStart()->format(DATE_ISO8601));
        $form->add($input);

        $input = new TextInput('date-end');
        $input->setLabel('date-end');
        if ($milestone && $milestone->getDateEnd()) $input->setValue($milestone->getDateEnd()->format(DATE_ISO8601));
        $form->add($input);

        $form->setInputFilter($this->getModelInputFilter());

        return $form;
    }

    public function getModelInputFilter()
    {
        $factory = new FilterFactory();
        $filter = new InputFilter();
        $filter->add($factory->createInput(array(
            'name'     => 'label',
            'required' => true,
        )))->add($factory->createInput(array(
            'name'     => 'description',
            'required' => false,
        )))->add($factory->createInput(array(
            'name'     => 'date-start',
            'required' => false,
        )))->add($factory->createInput(array(
            'name'     => 'date-end',
            'required' => false,
        )));

        return $filter;
    }
}

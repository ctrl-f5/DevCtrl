<?php

namespace DevCtrl\Service;

use \DevCtrl\Domain;
use DevCtrl\Domain\Project;
use DevCtrl\Domain\Item\Item;
use Zend\InputFilter\Factory as FilterFactory;
use Zend\InputFilter\InputFilter;
use DevCtrl\Domain\Item\Property\ValuesProvider\ProviderInterface as ValuesProvider;
use Ctrl\Form\Form;
use Ctrl\Form\Element\Text as TextInput;
use Ctrl\Form\Element\Textarea as TextareaInput;

class ProjectService extends \Ctrl\Service\AbstractDomainModelService
{
    protected $entity = 'DevCtrl\Domain\Project';

    /**
     * @param \DevCtrl\Domain\Project $project
     * @return Item[]
     */
    public function getBacklogItems(Project $project)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT i FROM DevCtrl\Domain\Item\Item i JOIN i.project p
                WHERE p.id = :id
                ORDER BY i.dateCreated DESC')
            ->setParameter('id', $project)
            ->getResult();
    }

    public function getForm(Project $project = null)
    {
        $form = new Form('form-project');

        $input = new TextInput('name');
        $input->setLabel('name');
        if ($project) $input->setValue($project->getName());
        $form->add($input);

        $input = new TextareaInput('description');
        $input->setLabel('description');
        if ($project) $input->setValue($project->getDescription());
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

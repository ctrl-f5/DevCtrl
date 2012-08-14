<?php

namespace DevCtrl\Service;

use \DevCtrl\Domain;
use \DevCtrl\Domain\Item\Item;
use \DevCtrl\Domain\Item\Type\Type;
use DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\User\User;
use DevCtrl\Domain\Project\Project;
use DevCtrl\Domain\Project\Milestone;
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

    public function getForm(Item $milestone = null)
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

        if ($type->supportsTiming()) {
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

        if ($type->supportsVersions()) {
            $input = new SelectInput();
            $input->setLabel('version')->setName('version-reported');
            $versions = array('');//add empty option, since not required
            if ($item) {
                foreach ($item->getProject()->getVersionList() as $v) {
                    $versions[$v->getId()] = $v->getVersion().' '.$v->getLabel();
                }
            }
            $input->setAttribute('options', $versions);
            if ($item && $item->getVersionReported()) $input->setValue($item->getVersionReported()->getId());
            elseif ($item && $item->getProject()->getVersion()) $input->setValue($item->getProject()->getVersion()->getId());
            $form->add($input);

            if ($item) {
                $input = new SelectInput();
                $input->setLabel('fixed in version')->setName('version-fixed');
                $input->setAttribute('options', $versions);
                if ($item && $item->getVersionFixed()) $input->setValue($item->getVersionFixed()->getId());
                elseif ($item->getProject()->getVersion()) $input->setValue($item->getProject()->getVersion()->getId());
                $form->add($input);
            }
        }

        if ($type->supportsStates()) {
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

    public function getModelInputFilter(Type $type)
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

        if ($type->supportsStates()) {
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

    /**
     * @param \DevCtrl\Domain\User\User $user
     * @param null|Project|Milestone $context
     * @return array
     */
    public function getItemsAssignedToUser(User $user, $context = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('i')
            ->from('DevCtrl\Domain\Item\Item', 'i')
            ->join('i.assignedUsers', 'iu')
            ->where('iu.id = :userid')
            ->orderBy('i.dateUpdate', 'DESC')
            ->setParameter('userid', $user->getId());

        if ($context instanceof Project) {
            $qb->join('i.project', 'p')
                ->andWhere('p.id = :projectid')
                ->setParameter('projectid', $context->getId());
        }
        if ($context instanceof Milestone) {
            $qb->join('i.milestones', 'm')
                ->andWhere('m.id = :milestoneid')
                ->setParameter('milestoneid', $context->getId());
        }

        return $qb->getQuery()->getResult();
    }

    public function getLastUpdatedItems($context = null, $maxResults = 0)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('i')
            ->from('DevCtrl\Domain\Item\Item', 'i')
            ->orderBy('i.dateUpdate', 'DESC');

        if ($context instanceof Project) {
            $qb->join('i.project', 'p')
                ->andWhere('p.id = :projectid')
                ->setParameter('projectid', $context->getId());
        }
        if ($context instanceof Milestone) {
            $qb->join('i.milestones', 'm')
                ->andWhere('m.id = :milestoneid')
                ->setParameter('milestoneid', $context->getId());
        }
        if ($maxResults) {
            $qb->setMaxResults($maxResults);
        }

        return $qb->getQuery()->getResult();
    }
}

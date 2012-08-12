<?php

namespace DevCtrl\Controller;

use DevCtrl\Domain\Project\Project;
use DevCtrl\Domain\Project\Version;
use DevCtrl\Domain\Project\Milestone;
use DevCtrl\Service\ProjectService;
use DevCtrl\Service\ItemService;
use DevCtrl\Service\MilestoneService;
use DevCtrl\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class MilestoneController extends AbstractController
{
    /**
     * @var string
     */
    protected $controllerName = 'milestone';

    public function indexAction()
    {
        try {
            /** @var $projectService ProjectService */
            $projectService = $this->getDomainService('Project');
            /** @var $project Project */
            $project = $projectService->getById($this->params()->fromRoute('id'));
        } catch (\Exception $e) {
            return $this->renderErrorPage('Looks like we couldn\'nt find that project...');
        }

        return new ViewModel(array(
            'project' => $project
        ));
    }

    public function createAction()
    {
        try {
            /** @var $milestoneService MilestoneService */
            $milestoneService = $this->getDomainService('Milestone');
            /** @var $projectService ProjectService */
            $projectService = $this->getDomainService('Project');
            /** @var $project Project */
            $project = $projectService->getById($this->params()->fromRoute('id'));

            $form = $milestoneService->getForm($project);
            $form->setAttribute('action', $this->url()->fromRoute('default/id', array(
                'controller' => 'milestone',
                'action' => 'create',
                'id' => $project->getId(),
            )));
            $form->setReturnUrl($this->url()->fromRoute('default/id', array(
                'controller' => 'milestone',
                'action' => 'index',
                'id' => $project->getId(),
            )));
        } catch (\Exception $e) {
            return $this->renderErrorPage('There was a problem creating you requested page.');
        }

        if ($this->getRequest()->isPost()) {

            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {

                try {

                    $milestone = new Milestone($project);
                    $elements = $form->getElements();
                    $milestone->setLabel($elements['label']->getValue());
                    $milestone->setDescription($elements['description']->getValue());

                    $version = $elements['version']->getValue();
                    if ($version) {
                        foreach ($project->getVersionList() as $v)
                            if ($v->getId() == $version) {
                                $milestone->setResultingVersion($v);
                                break;
                            }
                    } else {
                        $milestone->setResultingVersion(null);
                    }

                    if (isset($elements['date-start']) && $elements['date-start']->getValue()) {
                        $milestone->setDateStart(new \DateTime($elements['date-start']->getValue()));
                    }
                    if (isset($elements['date-end']) && $elements['date-end']->getValue()) {
                        $milestone->setDateEnd(new \DateTime($elements['date-end']->getValue()));
                    }

                    $project->addMilestone($milestone);
                    $milestoneService->persist($project);
                    return $this->redirect()->toUrl($form->getReturnurl());

                } catch (\Exception $e) {
                    $this->flashMessenger()->setNamespace('error')->addMessage(
                        'Something went wrong while saving your item.'
                    );
                }
            }
        }

        return new ViewModel(array(
            'project' => $project,
            'form' => $form,
        ));
    }

    public function editAction()
    {
        try {
            /** @var $milestoneService MilestoneService */
            $milestoneService = $this->getDomainService('Milestone');
            /** @var $milestone Milestone */
            $milestone = $milestoneService->getById($this->params()->fromRoute('id'));
        } catch (\Exception $e) {
            return $this->renderErrorPage('Milestone cound not be found.');
        }

        try {
            $form = $milestoneService->getForm($milestone);
            $form->setAttribute('action', $this->url()->fromRoute('default/id', array(
                'controller' => 'milestone',
                'action' => 'edit',
                'id' => $milestone->getId(),
            )));
            $form->setReturnUrl($this->url()->fromRoute('default/id', array(
                'controller' => 'milestone',
                'action' => 'detail',
                'id' => $milestone->getId(),
            )));
        } catch (\Exception $e) {
            return $this->redirectWithError(
                'Something went wrong while opening your milestone',
                $milestone->getId(), 'milestone', 'detail');
        }
        if ($this->getRequest()->isPost()) {

            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {

                try {

                    $elements = $form->getElements();
                    $milestone->setLabel($elements['label']->getValue());
                    $milestone->setDescription($elements['description']->getValue());

                    $version = $elements['version']->getValue();
                    if ($version) {
                        foreach ($milestone->getProject()->getVersionList() as $v)
                            if ($v->getId() == $version) {
                                $milestone->setResultingVersion($v);
                                break;
                            }
                    } else {
                        $milestone->setResultingVersion(null);
                    }

                    if (isset($elements['date-start']) && $elements['date-start']->getValue()) {
                        $milestone->setDateStart(new \DateTime($elements['date-start']->getValue()));
                    }
                    if (isset($elements['date-end']) && $elements['date-end']->getValue()) {
                        $milestone->setDateEnd(new \DateTime($elements['date-end']->getValue()));
                    }

                    $milestoneService->persist($milestone);
                    return $this->redirect()->toUrl($form->getReturnurl());

                } catch (\Exception $e) {
                    $this->flashMessenger()->setNamespace('error')->addMessage(
                        'Something went wrong while saving your item.'
                    );
                }
            }
        }

        return new ViewModel(array(
            'milestone' => $milestone,
            'form' => $form,
        ));
    }

    public function detailAction()
    {
        try {
            $milestoneService = $this->getDomainService('Milestone');
            /** @var $itemService ItemService */
            $itemService = $this->getDomainService('Item');
            $userService = $this->getDomainService('User');
            /** @var $milestone Milestone */
            $milestone = $milestoneService->getById($this->params()->fromRoute('id'));
            $userItems = $itemService->getItemsAssignedToUser($userService->getCurrentUser(), $milestone);
            $lastUpdatedItems = $itemService->getLastUpdatedItems($milestone, 5);
        } catch (\Exception $e) {
            throw $e;
            return $this->redirectWithError('Milestone detail could not be loaded.');
        }

        return new ViewModel(array(
            'milestone' => $milestone,
            'userItems' => $userItems,
            'lastUpdatedItems' => $lastUpdatedItems,
        ));
    }

    public function addItemAction()
    {
        try {
            /** @var $milestoneService MilestoneService */
            $milestoneService = $this->getDomainService('Milestone');
            /** @var $milestone Milestone */
            $milestone = $milestoneService->getById($this->params()->fromRoute('id'));
        } catch (\Exception $e) {
            return $this->redirectWithError('Looks like we couldn\'nt find that milestone...');
        }

        $itemId = $this->params()->fromQuery('item');
        if ($itemId) {
                try {
                    /** @var $itemService ItemService */
                    $itemService = $this->getDomainService('Item');
                    /** @var $item Item */
                    $item = $itemService->getById($itemId);

                    $milestone->addToBacklog($item);
                    $milestoneService->persist($milestone);

                    return $this->redirect()->toRoute('default/id', array(
                        'controller' => 'milestone',
                        'action' => 'detail',
                        'id' => $milestone->getId(),
                    ));
                } catch (\Exception $e) {
                    $this->flashMessenger()->setNamespace('error')->addMessage(
                        'Something went wrong while saving...'
                    );
                }
        }

        return new ViewModel(array(
            'milestone' => $milestone,
        ));
    }

    public function backlogAction()
    {
        $id = $this->params('id');
        /** @var $projectService ProjectService */
        $projectService = $this->getDomainService('project');
        /** @var $project Project */
        $project = $projectService->getById($id);

        $backlog = $projectService->getBacklogItems($project);

        return new ViewModel(array(
            'project' => $project,
            'backlog' => $backlog,
            'itemTypes' => $this->getDomainService('ItemType')->getAll()
        ));
    }
}

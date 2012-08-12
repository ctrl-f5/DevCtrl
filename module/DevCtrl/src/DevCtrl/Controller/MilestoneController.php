<?php

namespace DevCtrl\Controller;

use DevCtrl\Domain\Project\Project;
use DevCtrl\Domain\Project\Version;
use DevCtrl\Domain\Project\Milestone;
use DevCtrl\Service\ProjectService;
use DevCtrl\Service\ItemService;
use DevCtrl\Service\MilestoneService;
use Ctrl\Controller\AbstractController;
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

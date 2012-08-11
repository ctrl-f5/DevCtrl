<?php

namespace DevCtrl\Controller;

use DevCtrl\Domain\Project;
use DevCtrl\Service\ProjectService;
use Ctrl\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class ProjectController extends AbstractController
{
    /**
     * @var string
     */
    protected $controllerName = 'project';

    public function indexAction()
    {
        /** @var $projectService ProjectService */
        $projectService = $this->getDomainService('Project');

        return new ViewModel(array(
            'projects' => $projectService->getAll()
        ));
    }

    public function detailAction()
    {
        try {
            $projectService = $this->getDomainService('Project');
            $itemService = $this->getDomainService('Item');
            $userService = $this->getDomainService('User');
            $project = $projectService->getById($this->params()->fromRoute('id'));
            $userItems = $itemService->getItemsAssignedToUser($userService->getCurrentUser(), $project);
        } catch (\Exception $e) {
            return $this->redirectWithError('Project detail could not be loaded.');
        }

        return new ViewModel(array(
            'project' => $project,
            'userItems' => $userItems,
        ));
    }

    public function usersAction()
    {
        $id = $this->params('id');
        $project = $this->getDomainService('project')->getById($id);

        return new ViewModel(array(
            'project' => $project
        ));
    }

    public function addUserAction()
    {
        $id = $this->params('id');
        /** @var $projectService ProjectService */
        $projectService = $this->getDomainService('project');
        $project = $projectService->getById($id);

        if ($this->getRequest()->isPost()) {
            $userId = $this->params()->fromPost('user');
            $level = $this->params()->fromPost('level');

            /** @var $userService UserService */
            $userService = $this->getDomainService('user');
            $user = $userService->getById($userId);

            $projectService->linkUserToProject($project, $user, $level);
        }

        $users = $projectService->getUsersNotLinkedToProject($project);

        return new ViewModel(array(
            'project' => $project,
            'users' => $users
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

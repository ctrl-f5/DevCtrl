<?php

namespace DevCtrl\Controller;

use DevCtrl\Service\ProjectService;
use Ctrl\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class ProjectController extends AbstractController
{
    public function indexAction()
    {
        /** @var $projectService ProjectService */
        $projectService = $this->getDomainService('project');

        return new ViewModel(array(
            'projects' => $projectService->getAll()
        ));
    }

    public function detailAction()
    {
        return new ViewModel(array(
            'project' => $this->getDomainService('project')->getById($this->params('id'))
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

    public function itemsAction()
    {
        return new ViewModel(array(
            'project' => $this->getDomainService('project')->getById($this->params('id')),
            'itemTypes' => $this->getDomainService('ItemType')->getAll()
        ));
    }
}

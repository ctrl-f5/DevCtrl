<?php

namespace DevCtrl\Controller;

use DevCtrl\Domain\Project\Project;
use DevCtrl\Domain\Project\Version;
use DevCtrl\Service\ProjectService;
use DevCtrl\Service\ItemService;
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

    public function createAction()
    {
        /** @var $projectService ProjectService */
        $projectService = $this->getDomainService('Project');

        $form = $projectService->getForm();
        $form->setAttribute('action', $this->url()->fromRoute('default', array(
            'controller' => 'project',
            'action' => 'create',
        )));
        $form->setReturnUrl($this->url()->fromRoute('default/id', array(
            'controller' => 'project',
            'action' => 'index',
        )));

        if ($this->getRequest()->isPost()) {

            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $project = new Project();
                $elements = $form->getElements();
                $project->setName($elements['name']->getValue());
                $project->setDescription($elements['description']->getValue());

                $projectService->persist($project);

                return $this->redirect()->toUrl($form->getReturnurl());
            }
        }

        return new ViewModel(array(
            'form' => $form,
        ));
    }

    public function detailAction()
    {
        try {
            $projectService = $this->getDomainService('Project');
            /** @var $itemService ItemService */
            $itemService = $this->getDomainService('Item');
            $userService = $this->getDomainService('User');
            $project = $projectService->getById($this->params()->fromRoute('id'));
            $userItems = $itemService->getItemsAssignedToUser($userService->getCurrentUser(), $project);
            $lastUpdatedItems = $itemService->getLastUpdatedItems($project, 5);
        } catch (\Exception $e) {
            throw $e;
            return $this->redirectWithError('Project detail could not be loaded.');
        }

        return new ViewModel(array(
            'project' => $project,
            'userItems' => $userItems,
            'lastUpdatedItems' => $lastUpdatedItems,
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

    public function versionsAction()
    {
        try {
            $project = $this->getDomainService('project')->getById(
                $this->params()->fromRoute('id')
            );
        } catch (\Exception $e) {
            throw $e;
            return $this->redirectWithError('Project versions could not be loaded.');
        }

        return new ViewModel(array(
            'project' => $project
        ));
    }

    public function addVersionAction()
    {
        try {
            /** @var $projectService ProjectService */
            $projectService = $this->getDomainService('Project');
            /** @var $project Project */
            $project = $projectService->getById($this->params()->fromRoute('id'));
        } catch (\Exception $e) {
            return $this->redirectWithError('Looks like we couldn\'nt find that project...');
        }

        /** @var $versionService VersionService */
        $versionService = $this->getDomainService('Version');
        $form = $versionService->getForm();
        $form->setAttribute('action', $this->url()->fromRoute('default/id', array(
            'controller' => 'project',
            'action' => 'add-version',
            'id' => $project->getId()
        )));
        $form->setReturnUrl($this->url()->fromRoute('default/id', array(
            'controller' => 'project',
            'action' => 'versions',
            'id' => $project->getId()
        )));

        if ($this->getRequest()->isPost()) {

            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {

                try {
                    $elements = $form->getElements();
                    $version = new Version($project);
                    $version->setVersion($elements['version']->getValue());
                    $version->setLabel($elements['label']->getValue());
                    $version->setDescription($elements['description']->getValue());
                    $projectService->persist($project);
                } catch (\Exception $e) {
                    $this->flashMessenger()->setNamespace('error')->addMessage(
                        'Something went wrong while saving...'
                    );
                    throw $e;
                }
                return $this->redirect()->toUrl($form->getReturnurl());
            }
        }

        return new ViewModel(array(
            'project' => $project,
            'form' => $form
        ));
    }

    public function deleteVersionAction()
    {
        /** @var $stateService StateService */
        $stateService = $this->getDomainService('State');
        try {
            /** @var $state State */
            $state = $stateService->getById($this->params()->fromRoute('id'));
        } catch (\Exception $e) {
            return $this->redirectWithError('Looks like we couldn\'nt find that state...');
        }

        try {
            $list = $state->getList();
            if ($state && $stateService->canRemove($state)) {
                $stateService->remove($state);
            }
        } catch (\Exception $e) {
            return $this->redirectWithError('Looks like something went wrong while removing...');
        }

        return $this->redirect()->toRoute('default/id', array(
            'controller' => 'state-list',
            'action' => 'detail',
            'id' => $list->getId(),
        ));
    }

    public function changeVersionOrderAction()
    {
        /** @var $itemService \DevCtrl\Service\StateListService */
        $listService = $this->getDomainService('StateList');
        $list = $listService->getById($this->params()->fromQuery('id'));
        try {
            $list = $listService->getById($this->params()->fromQuery('id'));
        } catch (\Exception $e) {
            return $this->redirectWithError('Looks like we couldn\'nt find that list...');
        }

        $stateId = $this->params()->fromQuery('state');
        $dir = $this->params()->fromQuery('dir');

        try {
            $list->setStates(
                $listService->switchOrderInCollection(
                    $list->getStates(),
                    $stateId,
                    $dir
                )
            );
            $listService->persist($list);
        } catch (\Exception $e) {
            return $this->redirectWithError('Looks something went wrong while ordering...', $list->getId(), null, 'detail');
        }

        return $this->redirect()->toRoute('default/id', array(
            'controller' => 'state-list',
            'action' => 'detail',
            'id' => $list->getId()
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

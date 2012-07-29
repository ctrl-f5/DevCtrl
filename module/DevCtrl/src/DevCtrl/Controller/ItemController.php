<?php

namespace DevCtrl\Controller;

use DevCtrl\Service\ProjectService;
use Ctrl\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class ItemController extends AbstractController
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
        $id = $this->params('id');
        $project = $this->getDomainService('project')->getById($id);

        return new ViewModel(array(
            'project' => $project
        ));
    }

    public function createAction()
    {
        $project = $this->getDomainService('Project')->getById($this->params()->fromRoute('project'));
        $itemType = $this->getDomainService('ItemType')->getById($this->params()->fromRoute('item-type'));

        /** @var $itemService \DevCtrl\Service\ItemService */
        $itemService = $this->getDomainService('Item');
        //$itemService->create

        if ($this->getRequest()->isPost()) {

            $userId = 1; //TODO: get current user id

            /** @var $userService UserService */
            $userService = $this->getDomainService('user');
            $user = $userService->getById($userId);
        }

        return new ViewModel(array(
            'project' => $project,
            'itemType' => $itemType
        ));
    }

    public function itemTypePropertyControlsAction()
    {
        /** @var $itemType \DevCtrl\Domain\Item\ItemType */
        $itemType = $this->getDomainService('itemType')->getById($this->params()->fromQuery('id'));
        $view = new ViewModel(array(
            'itemType' => $itemType
        ));
        $view->setTerminal(true);
        return $view;
    }
}

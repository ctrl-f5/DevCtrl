<?php

namespace DevCtrl\Controller;

use DevCtrl\Service\ProjectService;
use Ctrl\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class ItemController extends AbstractController
{
    public function indexAction()
    {
        /** @var $itemService ItemService */
        $itemService = $this->getDomainService('Item');

        return new ViewModel(array(
            'items' => $itemService->getAll()
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

        if ($this->getRequest()->isPost()) {

            $userId = 1; //TODO fetch correct user
            $user = $userService = $this->getDomainService('User')->getById($userId);

            $item = $itemService->createItem(
                $this->params()->fromPost('title'),
                $user,
                $project,
                $itemType,
                $this->params()->fromPost('item-type-property')
            );

            $itemService->getEntityManager()->persist($item);
            $itemService->getEntityManager()->flush();

            return $this->redirect()->toRoute('default/id', array(
                'controller' => 'project',
                'action' => 'items',
                'id' => $project->getId()
            ));
        }

        return new ViewModel(array(
            'project' => $project,
            'itemType' => $itemType
        ));
    }
}

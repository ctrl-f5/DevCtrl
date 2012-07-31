<?php

namespace DevCtrl\Controller;

use DevCtrl\Domain;
use DevCtrl\Service\ProjectService;
use Ctrl\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class ItemTypeController extends AbstractController
{
    public function indexAction()
    {
        /** @var $itemTypeService ItemTypeService */
        $itemTypeService = $this->getDomainService('ItemType');

        return new ViewModel(array(
            'itemTypes' => $itemTypeService->getAll()
        ));
    }

    public function detailAction()
    {
        $id = $this->params('id');
        $itemType = $this->getDomainService('ItemType')->getById($id);

        return new ViewModel(array(
            'itemType' => $itemType
        ));
    }

    public function statesAction()
    {
        $id = $this->params('id');
        $itemType = $this->getDomainService('ItemType')->getById($id);

        return new ViewModel(array(
            'itemType' => $itemType
        ));
    }

    public function propertiesAction()
    {
        $id = $this->params('id');
        $itemType = $this->getDomainService('ItemType')->getById($id);

        return new ViewModel(array(
            'itemType' => $itemType
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

    public function createStateAction()
    {
        /** @var $itemService \DevCtrl\Service\ItemTypeService */
        $typeService = $this->getDomainService('ItemType');
        /** @var $itemType Domain\Item\ItemType */
        $itemType = $typeService->getById($this->params()->fromRoute('id'));

        if ($this->getRequest()->isPost()) {

            $state = new Domain\Item\State(
                $this->params()->fromPost('name'),
                $this->params()->fromPost('type')
            );

            $itemType->addState($state);

            $typeService->getEntityManager()->persist($itemType);
            $typeService->getEntityManager()->flush();

            return $this->redirect()->toRoute('default/id', array(
                'controller' => 'item-type',
                'action' => 'states',
                'id' => $itemType->getId()
            ));
        }

        return new ViewModel(array(
            'itemType' => $itemType
        ));
    }

    public function createPropertyAction()
    {
        /** @var $itemService \DevCtrl\Service\ItemTypeService */
        $typeService = $this->getDomainService('ItemType');
        /** @var $itemType Domain\Item\ItemType */
        $itemType = $typeService->getById($this->params()->fromRoute('id'));
        /** @var $propertyService \DevCtrl\Service\ItemPropertyService */
        $propertyService = $this->getDomainService('ItemProperty');

        if ($this->getRequest()->isPost()) {

            $state = new Domain\Item\State(
                $this->params()->fromPost('name'),
                $this->params()->fromPost('type')
            );

            $itemType->addState($state);

            $typeService->getEntityManager()->persist($itemType);
            $typeService->getEntityManager()->flush();

            return $this->redirect()->toRoute('default/id', array(
                'controller' => 'item-type',
                'action' => 'states',
                'id' => $itemType->getId()
            ));
        }

        return new ViewModel(array(
            'itemType' => $itemType,
            'defaultValueProviders' => $propertyService->getAllConfiguredDefaultValueProviders(),
            'possibleValuesProviders' => $propertyService->getAllConfiguredPossibleValuesProviders(),
        ));
    }

    public function stateOrderChangeAction()
    {
        /** @var $itemService \DevCtrl\Service\ItemTypeService */
        $typeService = $this->getDomainService('ItemType');
        /** @var $itemType Domain\Item\ItemType */
        $itemType = $typeService->getById($this->params()->fromRoute('id'));

        $state = $itemType->getState($this->params()->fromRoute('state'));
        if ($this->params()->fromRoute('direction') == 'up') {
            if ($state->getOrder() > 1) {
                foreach ($itemType->getStates() as $s) {
                    if ($s->getOrder() == $state->getOrder()-1) {
                        $state->setOrder($s->getOrder());
                        $s->setOrder($s->getOrder()+1);
                    }
                }
            }
        } else if ($this->params()->fromRoute('direction') == 'down') {
            if ($state->getOrder() > 1) {
                foreach ($itemType->getStates() as $s) {
                    if ($s->getOrder() == $state->getOrder()+1) {
                        $state->setOrder($s->getOrder());
                        $s->setOrder($s->getOrder()-1);
                    }
                }
            }
        }

        $typeService->getEntityManager()->persist($itemType);
        $typeService->getEntityManager()->flush();

        return $this->redirect()->toRoute('default/id', array(
            'controller' => 'item-type',
            'action' => 'states',
            'id' => $itemType->getId()
        ));
    }
}

<?php

namespace DevCtrl\Controller;

use DevCtrl\Domain;
use DevCtrl\Service\ProjectService;
use DevCtrl\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use DevCtrl\Service\StateListService;
use DevCtrl\Domain\Item\State\StateList;
use DevCtrl\Domain\Item\State\State;
class StateListController extends AbstractController
{
    public function indexAction()
    {
        /** @var $listService \DevCtrl\Service\StateListService */
        $listService = $this->getDomainService('StateList');
        return new ViewModel(array(
            'lists' => $listService->getAll(),
        ));
    }

    public function createAction()
    {
        /** @var $listService StateListService */
        $listService = $this->getDomainService('StateList');

        $form = $listService->getForm(new StateList());

        if ($this->getRequest()->isPost()) {

            $listService = $this->getDomainService('StateList');
            $list = new StateList();
            $list->setName($this->params()->fromPost('name'));

            $listService->persist($list);

            return $this->redirect()->toRoute('default/id', array(
                'controller' => 'state-list',
                'action' => 'detail',
                'id' => $list->getId(),
            ));
        }

        return new ViewModel(array(
            'form' => $form,
            'nativeStates' => State::getNativeStates()
        ));
    }

    public function detailAction()
    {
        $id = $this->params('id');
        $list = $this->getDomainService('StateList')->getById($id);

        return new ViewModel(array(
            'list' => $list
        ));
    }

    public function addStateAction()
    {
        /** @var $listService StateListService */
        $listService = $this->getDomainService('StateList');
        /** @var $list StateList */
        $list = $listService->getById($this->params()->fromRoute('id'));

        if ($this->getRequest()->isPost()) {

            $state = new State($this->params()->fromPost('native-state'), $list);
            $state->setLabel($this->params()->fromPost('label'))
                ->setColor($this->params()->fromPost('color'));
            $list->addState($state);

            $listService->persist($list);

            return $this->redirect()->toRoute('default/id', array(
                'controller' => 'state-list',
                'action' => 'detail',
                'id' => $list->getId(),
            ));
        }

        return new ViewModel(array(
            'list' => $list,
            'nativeStates' => State::getNativeStates()
        ));
    }
}

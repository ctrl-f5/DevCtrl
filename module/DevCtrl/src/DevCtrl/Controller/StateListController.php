<?php

namespace DevCtrl\Controller;

use DevCtrl\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use DevCtrl\Service\StateListService;
use DevCtrl\Service\StateService;
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
        $form->setReturnUrl($this->url()->fromRoute('default', array(
            'controller' => 'state-list',
            'action' => 'index',
        )));

        if ($this->getRequest()->isPost()) {

            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $list = new StateList();
                $list->setName($this->params()->fromPost('name'));

                $listService->persist($list);
                return $this->redirect()->toUrl($form->getReturnurl());
            }
        }

        return new ViewModel(array('form' => $form));
    }

    public function deleteAction()
    {
        /** @var $listService StateListService */
        $listService = $this->getDomainService('StateList');
        $list = $this->getDomainService('StateList')->getById($this->params('id'));
        if ($list && $listService->canRemove($list)) {
            $listService->remove($list);
        }

        return $this->redirect()->toRoute('default', array(
            'controller' => 'state-list',
            'action' => 'index',
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

        /** @var $stateService StateService */
        $stateService = $this->getDomainService('State');
        $form = $stateService->getForm();
        $form->setReturnUrl($this->url()->fromRoute('default/id', array(
            'controller' => 'state-list',
            'action' => 'detail',
            'id' => $list->getId()
        )));

        if ($this->getRequest()->isPost()) {

            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {

                $nativeState = State::getNativeStates($this->params()->fromPost('native-state'));
                $state = new State(
                    $nativeState,
                    $list,
                    $this->params()->fromPost('label'),
                    $this->params()->fromPost('color')
                );
                $list->addState($state);
                $listService->persist($list);

                return $this->redirect()->toUrl($form->getReturnurl());
            }
        }

        return new ViewModel(array(
            'list' => $list,
            'form' => $form
        ));
    }
}

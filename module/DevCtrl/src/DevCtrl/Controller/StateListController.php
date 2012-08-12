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
    /**
     * @var string
     */
    protected $controllerName = 'state-list';

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
        $form->setAttribute('action', $this->url()->fromRoute('default', array(
            'controller' => 'state-list',
            'action' => 'create',
        )));
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
        try {
            $list = $listService->getById($this->params()->fromRoute('id'));
        } catch (\Exception $e) {
            return $this->redirectWithError('Looks like we couldn\'nt find that list...');
        }

        if ($listService->canRemove($list)) {
            $listService->remove($list);
        }

        return $this->redirect()->toRoute('default', array(
            'controller' => 'state-list',
            'action' => 'index',
        ));
    }

    public function detailAction()
    {
        try {
            $listService = $this->getDomainService('StateList');
            $list = $listService->getById($this->params()->fromRoute('id'));
        } catch (\Exception $e) {
            return $this->redirectWithError('Looks like we couldn\'nt find that list...');
        }

        return new ViewModel(array(
            'list' => $list
        ));
    }

    public function addStateAction()
    {
        try {
            /** @var $listService StateListService */
            $listService = $this->getDomainService('StateList');
            /** @var $list StateList */
            $list = $listService->getById($this->params()->fromRoute('id'));
        } catch (\Exception $e) {
            return $this->redirectWithError('Looks like we couldn\'nt find that list...');
        }

        /** @var $stateService StateService */
        $stateService = $this->getDomainService('State');
        $form = $stateService->getForm();
        $form->setAttribute('action', $this->url()->fromRoute('default/id', array(
            'controller' => 'state-list',
            'action' => 'add-state',
            'id' => $list->getId()
        )));
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

    public function deleteStateAction()
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

    public function changeStateOrderAction()
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
}

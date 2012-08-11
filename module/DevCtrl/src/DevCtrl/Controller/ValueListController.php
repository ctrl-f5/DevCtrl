<?php

namespace DevCtrl\Controller;

use DevCtrl\Service\ProjectService;
use DevCtrl\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use DevCtrl\Domain\Value\Value;
use DevCtrl\Domain\Item\Property\Type\TypeInterface;
use DevCtrl\Domain\Item\Property\Value\ListValue;
use DevCtrl\Domain\Item\Property\Value\ValueList;
use DevCtrl\Service\ValueListService;
use DevCtrl\Service\ValueService;
use DevCtrl\Service\ListValueService;

class ValueListController extends AbstractController
{
    /**
     * @var string
     */
    protected $controllerName = 'value-list';

    public function indexAction()
    {
        /** @var $listService \DevCtrl\Service\ValueListService */
        $listService = $this->getDomainService('ValueList');
        return new ViewModel(array(
            'lists' => $listService->getAll(),
            'nativeTypes' => Value::getNativeValueTypes(),
        ));
    }

    public function detailAction()
    {
        try {
            $list = $this->getDomainService('ValueList')->getById($this->params()->fromRoute('id'));
        } catch (\Exception $e) {
            return $this->redirectWithError('Looks like we couldn\'nt find that list...');
        }

        return new ViewModel(array(
            'list' => $list,
            'nativeTypes' => Value::getNativeValueTypes(),
        ));
    }

    public function createAction()
    {
        $valueType = $this->getNativeValueType($this->params()->fromRoute('type'));
        /** @var $listService ValueListService */
        $listService = $this->getDomainService('ValueList');
        $form = $listService->getFormForType($valueType);
        $form->setAttribute('action', $this->url()->fromRoute('value_list_create', array(
            'controller' => 'value-list',
            'action' => 'create',
            'type' => $valueType->getNativeValueType()
        )));
        $form->setReturnUrl($this->url()->fromRoute('default', array(
            'controller' => 'value-list',
            'action' => 'index',
        )));

        if ($this->getRequest()->isPost()) {

            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {

                $list = new ValueList(
                    $this->params()->fromPost('name'),
                    $valueType->getNativeValueType()
                );

                $listService->persist($list);

                return $this->redirect()->toUrl($form->getReturnurl());

            }
        }

        return new ViewModel(array(
            'form' => $form,
            'type' => $valueType,
        ));
    }

    public function addValueAction()
    {
        try {
            /** @var $listService ValueListService */
            $listService = $this->getDomainService('ValueList');
            /** @var $list ValueList */
            $list = $this->getDomainService('ValueList')->getById($this->params()->fromRoute('id'));
        } catch (\Exception $e) {
            return $this->redirectWithError('Looks like we couldn\'nt find that list...');
        }

        if ($this->getRequest()->isPost()) {

            $value = $this->getNativeValueType($list->getNativeType());
            $value->setValue($this->params()->fromPost('value'));
            $list->addValue($value);

            $listService->persist($list);

            return $this->redirect()->toRoute('default/id', array(
                'controller' => 'value-list',
                'action' => 'detail',
                'id' => $list->getId(),
            ));
        }

        return new ViewModel(array(
            'list' => $list,
            'nativeType' => $this->getNativeValueType($list->getNativeType())
        ));
    }

    public function deleteValueAction()
    {
        try {
            /** @var $valueService ListValueService */
            $valueService = $this->getDomainService('ListValue');
            /** @var $value ListValue */
            $value = $valueService->getById($this->params()->fromRoute('id'));
        } catch (\Exception $e) {
            return $this->redirectWithError('Looks like we couldn\'nt find that list...');
        }

        $valueService->remove($value);

        return $this->redirect()->toRoute('default/id', array(
            'controller' => 'value-list',
            'action' => 'detail',
            'id' => $value->getList()->getId(),
        ));
    }

    public function changeValueOrderAction()
    {
        /** @var $valueService \DevCtrl\Service\ListValueService */
        $valueService = $this->getDomainService('ListValue');
        /** @var $value ListValue */
        $value = $valueService->getById($this->params()->fromRoute('id'));

        $dir = $this->params()->fromQuery('dir');

        $value->getList()->setValues(
            $valueService->switchOrderInCollection(
                $value->getList()->getValues(),
                $value->getId(),
                $dir
            )
        );

        $valueService->persist($value);

        return $this->redirect()->toRoute('default/id', array(
            'controller' => 'value-list',
            'action' => 'detail',
            'id' => $value->getList()->getId()
        ));
    }
}

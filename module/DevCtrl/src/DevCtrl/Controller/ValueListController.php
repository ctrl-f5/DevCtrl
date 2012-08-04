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
        $id = $this->params('id');
        $list = $this->getDomainService('ValueList')->getById($id);

        return new ViewModel(array(
            'list' => $list,
            'nativeTypes' => Value::getNativeValueTypes(),
        ));
    }

    public function addValueAction()
    {
        /** @var $listService ValueListService */
        $listService = $this->getDomainService('ValueList');
        /** @var $list ValueList */
        $list = $listService->getById($this->params()->fromRoute('id'));

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
        /** @var $valueService ListValueService */
        $valueService = $this->getDomainService('ListValue');
        /** @var $value ListValue */
        $value = $valueService->getById($this->params()->fromRoute('id'));

        if ($value) {
            $valueService->remove($value);

            return $this->redirect()->toRoute('default/id', array(
                'controller' => 'value-list',
                'action' => 'detail',
                'id' => $value->getList()->getId(),
            ));
        }

        return $this->redirect()->toRoute('default', array(
            'controller' => 'value-list',
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

<?php

namespace DevCtrl\Controller;

use DevCtrl\Domain;
use DevCtrl\Service\ProjectService;
use DevCtrl\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use DevCtrl\Domain\Item\Property\Type\TypeInterface;
use DevCtrl\Domain\Item\Property\Value\Value;
use DevCtrl\Domain\Item\Property\Value\ValueList;
use DevCtrl\Service\ValueListService;

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
}

<?php

namespace DevCtrl\Controller;

use DevCtrl\Domain;
use DevCtrl\Service\ProjectService;
use Ctrl\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class PropertyController extends AbstractController
{
    public function detailAction()
    {
        $id = $this->params('id');
        $property = $this->getDomainService('ItemProperty')->getById($id);

        return new ViewModel(array(
            'property' => $property
        ));
    }

    public function addValueAction()
    {
        $id = $this->params('id');
        $propertyService = $this->getDomainService('ItemProperty');
        /** @var $property \DevCtrl\Domain\Item\Property */
        $property = $propertyService->getById($id);

        if ($this->getRequest()->isPost()) {

            $value = new \DevCtrl\Domain\Item\Property\CustomPossibleValue();
            $value->setValue($this->params()->fromPost('value'));
            $property->addCustomPossibleValue($value);

            $propertyService->getEntityManager()->persist($value);
            $propertyService->getEntityManager()->flush();

            return $this->redirect()->toRoute('default/id', array(
                'controller' => 'property',
                'action' => 'detail',
                'id' => $property->getId()
            ));
        }

        return new ViewModel(array(
            'property' => $property
        ));
    }
}

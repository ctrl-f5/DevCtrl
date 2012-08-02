<?php

namespace DevCtrl\Controller;

use DevCtrl\Domain;
use DevCtrl\Service\ProjectService;
use DevCtrl\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use DevCtrl\Domain\Item\Property\Type\TypeInterface;

class PropertyController extends AbstractController
{
    public function indexAction()
    {
        /** @var $propertyService \DevCtrl\Service\PropertyService */
        $propertyService = $this->getDomainService('Property');
        return new ViewModel(array(
            'properties' => $propertyService->getAll(),
            'types' => $this->getConfiguredPropertyTypes(),
        ));
    }

    public function createAction()
    {
        $propertyType = $this->getPropertyType($this->params()->fromRoute('type'));

        /** @var $propertyService \DevCtrl\Service\PropertyService */
        $propertyService = $this->getDomainService('Property');

        if ($this->getRequest()->isPost()) {

            $property = new \DevCtrl\Domain\Item\Property\Property(
                $propertyType,
                $this->params()->fromPost('type'),
                $this->params()->fromPost('type-config')
            );
            $property->setName($this->params()->fromPost('name'))
                ->setDescription($this->params()->fromPost('description'));

            $propertyService->persist($property);

            return $this->redirect()->toRoute('default', array(
                'controller' => 'property',
                'action' => 'index',
            ));
        }

        return new ViewModel(array(
            'type' => $propertyType,
            'valuesProviders' => $propertyService->getConfiguredValuesProviders()
        ));
    }
}

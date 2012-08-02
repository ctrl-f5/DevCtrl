<?php

namespace DevCtrl\Controller;

use DevCtrl\Domain;
use DevCtrl\Service\ProjectService;
use DevCtrl\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use DevCtrl\Service\ItemTypeService;
use DevCtrl\Domain\Item\Type\Type;
use DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\Type\TypeProperty;

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
        /** @var $itemService \DevCtrl\Service\ItemService */
        $itemService = $this->getDomainService('Item');
        /** @var $stateService \DevCtrl\Service\StateListService */
        $stateService = $this->getDomainService('StateList');

        if ($this->getRequest()->isPost()) {

            $itemType = new Type(
                $this->params()->fromPost('supports-timing'),
                $this->params()->fromPost('supports-states')
            );
            $itemType->setName($this->params()->fromPost('name'))
                ->setDescription($this->params()->fromPost('description'));

            $itemType->setStates($stateService->getById(
                $this->params()->fromPost('state-list')
            ));

            $itemService->getEntityManager()->persist($itemType);
            $itemService->getEntityManager()->flush();

            return $this->redirect()->toRoute('default/id', array(
                'controller' => 'item-type',
                'action' => 'index'
            ));
        }

        return new ViewModel(array(
            'states' => $stateService->getAll()
        ));
    }

    public function selectLinkPropertyAction()
    {
        /** @var $typeService \DevCtrl\Service\ItemTypeService */
        $typeService = $this->getDomainService('ItemType');
        /** @var $itemType Domain\Item\Type\Type */
        $itemType = $typeService->getById($this->params()->fromRoute('id'));
        /** @var $propertyService \DevCtrl\Service\PropertyService */
        $propertyService = $this->getDomainService('Property');

        return new ViewModel(array(
            'itemType' => $itemType,
            'properties' => $propertyService->getAll(),
        ));
    }

    public function linkPropertyAction()
    {
        /** @var $typeService \DevCtrl\Service\ItemTypeService */
        $typeService = $this->getDomainService('ItemType');
        /** @var $itemType Domain\Item\Type\Type */
        $itemType = $typeService->getById($this->params()->fromRoute('type'));
        /** @var $propertyService \DevCtrl\Service\PropertyService */
        $propertyService = $this->getDomainService('Property');
        /** @var $property Property */
        $property = $propertyService->getById($this->params()->fromRoute('property'));

        if ($this->getRequest()->isPost()) {

            $typeProperty = new TypeProperty($this->getServiceLocator(), $property, $this->params()->fromPost('default-provider'));

            if ($property->getValuesProvider()->supportsDefaultValue()) {

                $typeProperty->setRequired($this->params()->fromPost('required'));

                if ($typeProperty->getDefaultProvider()->requiresConfiguration()) {
                    $typeProperty->setDefaultProviderConfig($this->params()->fromPost('default-provider-config'));
                }

                $itemType->addProperty($typeProperty);
                $typeService->persist($itemType);

                return $this->redirect()->toRoute('default/id', array(
                    'controller' => 'item-type',
                    'action' => 'properties',
                    'id' => $itemType->getId()
                ));
            }
        }

        return new ViewModel(array(
            'itemType' => $itemType,
            'property' => $property,
            'defaultProviders' => $propertyService->getConfiguredDefaultValueProviders(),
        ));
    }
}

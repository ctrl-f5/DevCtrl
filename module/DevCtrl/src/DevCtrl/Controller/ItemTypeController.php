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
use DevCtrl\Domain\Item\State\StateList;

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
        /** @var $typeService \DevCtrl\Service\ItemTypeService */
        $typeService = $this->getDomainService('ItemType');
        $form = $typeService->getForm();
        $form->setAttribute('action', $this->url()->fromRoute('default', array(
            'controller' => 'item-type',
            'action' => 'create',
        )));
        $form->setReturnUrl($this->url()->fromRoute('default', array(
            'controller' => 'item-type',
            'action' => 'index',
        )));

        if ($this->getRequest()->isPost()) {

            $itemType = new Type(
                $this->params()->fromPost('supports-timing'),
                $this->params()->fromPost('supports-states')
            );
            $itemType->setName($this->params()->fromPost('name'))
                ->setDescription($this->params()->fromPost('description'));

            /** @var $stateList StateList */
            $stateList = $this->getDomainService('StateList')
                ->getById($this->params()->fromPost('state-list'));
            if (!$stateList) {
                throw new Exception('Failed to load state list: '.$this->params()->fromPost('state-list'));
            }
            $itemType->setStates($stateList);

            $typeService->getEntityManager()->persist($itemType);
            $typeService->getEntityManager()->flush();

            return $this->redirect()->toRoute('default/id', array(
                'controller' => 'item-type',
                'action' => 'index'
            ));
        }

        return new ViewModel(array(
            'form' => $form,
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
            $typeProperty->setRequired($this->params()->fromPost('required'));

            if ($property->getType()->supportsProvidingValues()
                && $property->getValuesProvider()->supportsDefaultValue()
                && $property->getType()->supportsDefaultValue()) {

                if ($typeProperty->getDefaultProvider()->requiresConfiguration()) {
                    $typeProperty->setDefaultProviderConfig($this->params()->fromPost('default-provider-config'));
                }
            }
            $itemType->addProperty($typeProperty);
            $typeService->persist($itemType);

            return $this->redirect()->toRoute('default/id', array(
                'controller' => 'item-type',
                'action' => 'properties',
                'id' => $itemType->getId()
            ));
        }

        return new ViewModel(array(
            'itemType' => $itemType,
            'property' => $property,
            'defaultProviders' => $propertyService->getConfiguredDefaultValueProviders(),
        ));
    }

    public function changePropertyOrderAction()
    {
        /** @var $itemService \DevCtrl\Service\ItemTypePropertyService */
        $typeService = $this->getDomainService('ItemTypeProperty');
        /** @var $typeProp TypeProperty */
        $typeProp = $typeService->getById($this->params()->fromRoute('id'));

        $dir = $this->params()->fromQuery('dir');

        $typeProp->getItemType()->setTypeProperties(
            $typeService->switchOrderInCollection(
                $typeProp->getItemType()->getTypeProperties(),
                $typeProp->getId(),
                $dir
            )
        );

        $typeService->persist($typeProp);

        return $this->redirect()->toRoute('default/id', array(
            'controller' => 'item-type',
            'action' => 'properties',
            'id' => $typeProp->getId()
        ));
    }
}

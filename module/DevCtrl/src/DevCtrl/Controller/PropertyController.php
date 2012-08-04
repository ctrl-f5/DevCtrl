<?php

namespace DevCtrl\Controller;

use DevCtrl\Domain;
use DevCtrl\Service\PropertyService;
use DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\Property\Type\TypeInterface;
use DevCtrl\Controller\AbstractController;
use Zend\View\Model\ViewModel;

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
        /** @var $propertyType TypeInterface */
        $propertyType = $this->getPropertyType($this->params()->fromRoute('type'));
        /** @var $propertyService \DevCtrl\Service\PropertyService */
        $propertyService = $this->getDomainService('Property');
        $form = $propertyService->getFormForType($propertyType);
        $form->setAttribute('action', $this->url()->fromRoute('property_create', array(
            'controller' => 'property',
            'action' => 'create',
            'type' => $propertyType->getNativeValueType()
        )));
        $form->setReturnUrl($this->url()->fromRoute('default', array(
            'controller' => 'property',
            'action' => 'index',
        )));

        if ($this->getRequest()->isPost()) {

            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {

                $elems = $form->getElements();
                $type = null;
                $typeconfig = null;
                if (isset($elems['type'])) {
                    $type = $elems['type']->getValue();
                    $configKey = 'type-config-'.strtolower($elems['type']->getValue());
                    if (isset($elems[$configKey])) $typeConfig = $elems[$configKey]->getValue();
                }
                $property = new Property(
                    $propertyType,
                    $type,
                    $typeConfig
                );
                $property
                    ->setName($elems['name']->getValue())
                    ->setDescription($elems['description']->getValue());

                $propertyService->persist($property);

                return $this->redirect()->toUrl($form->getReturnurl());

            }
        }

        return new ViewModel(array(
            'form' => $form,
            'type' => $propertyType,
            'valuesProviders' => $propertyService->getConfiguredValuesProviders()
        ));
    }

    public function deleteAction()
    {
        /** @var $propertyService PropertyService */
        $propertyService = $this->getDomainService('Property');
        /** @var $property Property */
        $property = $this->getDomainService('Property')->getById($this->params('id'));
        if ($property && $propertyService->canRemove($property)) {
            $propertyService->remove($property);
        }

        return $this->redirect()->toRoute('default', array(
            'controller' => 'property',
            'action' => 'index',
        ));
    }
}

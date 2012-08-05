<?php

namespace DevCtrl\Controller;

use Ctrl\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use DevCtrl\Service\ItemService;
use DevCtrl\Service\ItemTypeService;
use DevCtrl\Domain\Item\Type\Type;
use DevCtrl\Domain\Item\Item;
use DevCtrl\Domain\Item\ItemProperty;

class ItemController extends AbstractController
{
    public function indexAction()
    {
        /** @var $itemService ItemService */
        $itemService = $this->getDomainService('Item');
        /** @var $itemTypeService ItemTypeService */
        $itemTypeService = $this->getDomainService('ItemType');

        return new ViewModel(array(
            'items' => $itemService->getAll(),
            'itemTypes' => $itemTypeService->getAll()
        ));
    }

    public function detailAction()
    {
        $id = $this->params('id');
        $item = $this->getDomainService('Item')->getById($id);

        return new ViewModel(array(
            'item' => $item
        ));
    }

    public function createAction()
    {
        /** @var $itemType Type */
        $itemType = $this->getDomainService('ItemType')->getById($this->params()->fromRoute('type'));
        /** @var $itemService \DevCtrl\Service\ItemService */
        $itemService = $this->getDomainService('Item');
        $form = $itemService->getFormForType($itemType);
        $form->setAttribute('action', $this->url()->fromRoute('item_create', array(
            'controller' => 'item',
            'action' => 'create',
            'type' => $itemType->getId(),
        )));
        $form->setReturnUrl($this->url()->fromRoute('default', array(
            'controller' => 'item',
            'action' => 'index',
        )));

        if ($this->getRequest()->isPost()) {

            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $item = new \DevCtrl\Domain\Item\Item($itemType);
                $elements = $form->getElements();
                $item->setTitle($elements['title']->getValue());
                $item->setDescription($elements['description']->getValue());

                if ($itemType->supportsTiming()) {
                    $counter = new \DevCtrl\Domain\Item\Timing\Counter();
                    $counter->setItem($item)
                        ->setEstimated($elements['timing-estimated']->getValue())
                        ->setExecuted(0);
                    $itemService->getEntityManager()->persist($counter);
                }
                if ($itemType->hasStates()) {
                    $item->setStateById($elements['state']->getValue());
                }

                foreach ($itemType->getTypeProperties() as $tp) {
                    $k = 'property-'.$tp->getId();
                    if (isset($elements[$k])) {
                        $item->setItemProperty($tp->getProperty(), $elements[$k]->getValue());
                    }
                }

                $itemService->getEntityManager()->persist($item);
                $itemService->getEntityManager()->flush();

                return $this->redirect()->toUrl($form->getReturnurl());
            }
        }

        return new ViewModel(array(
            'itemType' => $itemType,
            'form' => $form,
        ));
    }
}

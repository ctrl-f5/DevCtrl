<?php

namespace DevCtrl\Controller;

use Zend\View\Model\ViewModel;
use DevCtrl\Service\ItemService;
use DevCtrl\Service\ItemTypeService;
use DevCtrl\Domain\Item\Type\Type;
use DevCtrl\Domain\Item\Item;
use DevCtrl\Domain\Item\ItemProperty;
use DevCtrl\Domain\Project\Project;

class ItemController extends AbstractController
{
    /**
     * @var string
     */
    protected $controllerName = 'item';

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
        try {
            $item = $this->getDomainService('Item')->getById($this->params()->fromRoute('id'));
        } catch (\Exception $e) {
            return $this->renderErrorPage('Item not found');
        }

        return new ViewModel(array(
            'item' => $item
        ));
    }

    public function createAction()
    {
        try {
            /** @var $itemType Type */
            $itemType = $this->getDomainService('ItemType')->getById($this->params()->fromRoute('type'));
            /** @var $project Project */
            $project = $this->getDomainService('Project')->getById($this->params()->fromRoute('project'));
        } catch (\Exception $e) {
            return $this->renderErrorPage('Item Type or Project cound not be found.');
        }
        /** @var $itemService \DevCtrl\Service\ItemService */
        $itemService = $this->getDomainService('Item');
        $form = $itemService->getFormForType($itemType);
        $form->setAttribute('action', $this->url()->fromRoute('item_create', array(
            'type' => $itemType->getId(),
            'project' => $project->getId(),
        )));
        $form->setReturnUrl($this->url()->fromRoute('default/id', array(
            'controller' => 'project',
            'action' => 'backlog',
            'id' => $project->getId(),
        )));

        if ($this->getRequest()->isPost()) {

            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $item = new \DevCtrl\Domain\Item\Item($itemType, $this->getCurrentUser());
                $elements = $form->getElements();
                $item->setTitle($elements['title']->getValue());
                $item->setDescription($elements['description']->getValue());

                if ($itemType->supportsTiming()) {
                    $counter = new \DevCtrl\Domain\Item\Timing\Counter();
                    $counter->setItem($item)
                        ->setEstimated($elements['timing-estimated']->getValue())
                        ->setExecuted($elements['timing-executed']->getValue());
                    $itemService->getEntityManager()->persist($counter);
                }
                if ($itemType->supportsStates()) {
                    $item->setStateById($elements['state']->getValue());
                }

                foreach ($itemType->getTypeProperties() as $tp) {
                    $k = 'property-'.$tp->getId();
                    if (isset($elements[$k])) {
                        $item->setItemProperty($tp->getProperty(), $elements[$k]->getValue());
                    }
                }

                $project->addToBacklog($item);
                $itemService->persist($project);

                return $this->redirect()->toUrl($form->getReturnurl());
            }
        }

        return new ViewModel(array(
            'itemType' => $itemType,
            'project' => $project,
            'form' => $form,
        ));
    }

    public function editAction()
    {
        try {
            /** @var $itemService \DevCtrl\Service\ItemService */
            $itemService = $this->getDomainService('Item');
            /** @var $item Item */
            $item = $itemService->getById($this->params()->fromRoute('id'));
        } catch (\Exception $e) {
            return $this->renderErrorPage('Item cound not be found.');
        }

        try {
            $form = $itemService->getFormForType($item->getItemType(), $item);
            $form->setAttribute('action', $this->url()->fromRoute('default/id', array(
                'controller' => 'item',
                'action' => 'edit',
                'id' => $item->getId(),
            )));
            $form->setReturnUrl($this->url()->fromRoute('default/id', array(
                'controller' => 'item',
                'action' => 'detail',
                'id' => $item->getId(),
            )));
        } catch (\Exception $e) {
            return $this->redirectWithError(
                'Something went wrong while opening your item',
                $item->getId(), 'item', 'detail');
        }

        if ($this->getRequest()->isPost()) {

            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {

                try {

                    $elements = $form->getElements();
                    $item->setTitle($elements['title']->getValue());
                    $item->setDescription($elements['description']->getValue());

                    if ($item->getItemType()->supportsTiming()) {
                        $item->getTimeCounter()
                            ->setEstimated($elements['timing-estimated']->getValue())
                            ->setExecuted($elements['timing-executed']->getValue());
                    }
                    if ($item->getItemType()->supportsStates() && $item->getState()->getId() != $elements['state']->getValue()) {
                        $item->setStateById($elements['state']->getValue());
                    }

                    if ($item->getItemType()->supportsVersions()) {
                        $version = $elements['version-reported']->getValue();
                        if ($version) {
                            foreach ($item->getProject()->getVersionList() as $v)
                                if ($v->getId() == $version) {
                                    $item->setVersionReported($v);
                                    break;
                                }
                        } else {
                            $item->setVersionReported(null);
                        }
                        if (isset($elements['version-fixed'])) {
                            $version = $elements['version-fixed']->getValue();
                            if ($version) {
                                foreach ($item->getProject()->getVersionList() as $v)
                                    if ($v->getId() == $version) {
                                        $item->setVersionFixed($v);
                                        break;
                                    }
                            } else {
                                $item->setVersionFixed(null);
                            }
                        }
                    }

                    foreach ($item->getItemType()->getTypeProperties() as $tp) {
                        $k = 'property-'.$tp->getId();
                        if (isset($elements[$k])) {
                            $item->getItemProperty($tp->getProperty())->getValue()->setValue($elements[$k]->getValue());
                        }
                    }

                    $item->touch();
                    $itemService->persist($item);

                } catch (\Exception $e) {
                    $this->flashMessenger()->setNamespace('error')->addMessage(
                        'Something went wrong while saving your item.'
                    );
                }

                return $this->redirect()->toUrl($form->getReturnurl());
            }
        }

        return new ViewModel(array(
            'item' => $item,
            'form' => $form,
        ));
    }

    public function assignedUsersAction()
    {
        try {
            $item = $this->getDomainService('Item')->getById($this->params()->fromRoute('id'));
        } catch (\Exception $e) {
            return $this->renderErrorPage('Item cound not be found.');
        }

        return new ViewModel(array(
            'item' => $item
        ));
    }

    public function assignUserAction()
    {
        try {
            /** @var $item Item */
            $item = $this->getDomainService('Item')->getById($this->params()->fromRoute('id'));
        } catch (\Exception $e) {
            return $this->renderErrorPage('Item cound not be found.');
        };

        /** @var $userService \DevCtrl\Service\UserService */
        $userService = $this->getDomainService('User');

        $userId = $this->params()->fromQuery('user');
        if ($userId) {
            try {
                $user = $userService->getById($userId);
                $item->assignUser($user);
                $userService->persist($item);
            } catch (\Exception $e) {
                $this->flashMessenger()->setNamespace('error')->addMessage('Something went wrong while assigning the user to this item');
            }

            return $this->redirect()->toRoute('default/id', array(
                'controller' => 'item',
                'action' => 'assigned-users',
                'id' => $item->getId(),
            ));
        }

        return new ViewModel(array(
            'item' => $item,
            'users' => $userService->getUsersNotAssignedToItem($item)
        ));
    }
}

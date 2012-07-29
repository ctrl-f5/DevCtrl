<?php

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em = null;

    /**
     * @param \Doctrine\ORM\EntityManager $manager
     * @return IndexController
     */
    public function setEntityManager(\Doctrine\ORM\EntityManager $manager)
    {
        $this->em = $manager;
        return $this;
    }

    /**
     * @return \Doctrine\ORM\EntityManager|null
     */
    public function getEntityManager()
    {
        return $this->em;
    }

    public function indexAction()
    {
        $user = new \Auth\Domain\User();
        $user->setUsername('test');
        $user->setPassword('tester');

        //$this->getEntityManager()->persist($user);
        //$this->getEntityManager()->flush();

        var_dump($user->getId());
        return new ViewModel();
    }
}

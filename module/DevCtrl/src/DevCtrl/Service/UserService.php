<?php

namespace DevCtrl\Service;

use \DevCtrl\Domain;
use Ctrl\Service\AbstractDomainModelService;

class UserService extends AbstractDomainModelService
{
    protected $entity = 'DevCtrl\Domain\User\User';

    public function getCurrentUser()
    {
        return $this->getById(1);
    }
}

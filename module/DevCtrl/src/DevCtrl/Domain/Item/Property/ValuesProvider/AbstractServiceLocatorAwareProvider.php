<?php

namespace DevCtrl\Domain\Item\Property\ValuesProvider;

use DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\Property\Value;
use DevCtrl\Domain\Item\Item;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractServiceLocatorAwareProvider
    extends AbstractProvider
    implements ServiceLocatorAwareInterface
{
    public function requiresConfiguration()
    {
        return false;
    }

    public function getConfigurationValues()
    {
        if (!$this->requiresConfiguration()) {
            throw new \DevCtrl\Domain\Exception('this ValuesProvider does not require configuration');
        }
        return $this->_getConfigurationValues();
    }

    protected function _getConfigurationValues()
    {
        if ($this->requiresConfiguration()) {
            throw new \DevCtrl\Domain\Exception('no require configuration present! override this method');
        }
        return array();
    }


    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return CustomPossibleValuesProvider
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    /**
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

}

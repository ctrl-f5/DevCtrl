<?php

namespace DevCtrl\Service;

use DevCtrl\Domain\Item\Property\Property;
use DevCtrl\Domain\Item\Property\Type\TypeInterface;
use Zend\InputFilter\Factory as FilterFactory;
use Zend\InputFilter\InputFilter;
use DevCtrl\Domain\Item\Property\ValuesProvider\ProviderInterface as ValuesProvider;
use Ctrl\Form\Form;
use Ctrl\Form\Element\Text as TextInput;
use Ctrl\Form\Element\Select as SelectInput;

class PropertyService extends \Ctrl\Service\AbstractDomainModelService
{
    protected $entity = 'DevCtrl\Domain\Item\Property\Property';

    public function getConfiguredDefaultValueProviders()
    {
        $config = $this->getServiceLocator()->get('Configuration');
        $k = \DevCtrl\Module::ITEM_PROP_DEFAULT_PROVIDERS;
        if (isset($config[$k])) {
            $providers = array();
            foreach ($config[$k] as $k => $v) {
                $providers[$k] = $this->getServiceLocator()
                    ->get('DefaultProviderLoader')
                    ->get($k);
            }
            return $providers;
        }
        return array();
    }

    /**
     * @param $providerName
     * @return \DevCtrl\Domain\Item\Property\DefaultProvider\ProviderInterface
     */
    public function getConfiguredDefaultValueProvider($providerName)
    {
        return $this->getServiceLocator()
            ->get('DefaultProviderLoader')
            ->get($providerName);
    }

    /**
     * @return array|ValuesProvider[]
     */
    public function getConfiguredValuesProviders()
    {
        $config = $this->getServiceLocator()->get('Configuration');
        $k = \DevCtrl\Module::ITEM_PROP_VALUES_PROVIDERS;
        if (isset($config[$k])) {
            $providers = array();
            foreach ($config[$k] as $k => $v) {
                $providers[$k] = $this->getServiceLocator()
                    ->get('ValuesProviderLoader')
                    ->get($k);
            }
            return $providers;
        }
        return array();
    }

    public function getForm(Property $property = null)
    {
        throw new Exception('this method is not supported on this service, use the getForm*() functions instead');
    }

    public function getFormForType(TypeInterface $type, Property $property = null)
    {
        $form = new Form('create-item-property');

        $input = new TextInput('name');
        $input->setLabel('name');
        if ($property) $input->setValue($property->getName());
        $form->add($input);

        $input = new TextInput('description');
        $input->setLabel('description');
        if ($property) $input->setValue($property->getDescription());
        $form->add($input);

        if ($type->supportsProvidingValues()) {

            $typeOptions = array();
            $typeConfigs = array();
            foreach ($this->getConfiguredValuesProviders() as $k => $vp) {
                $typeOptions[$k] = $k;
                if (!$vp->requiresConfiguration()) continue;
                $typeConfigInput = new SelectInput();
                $typeConfigs[] = $typeConfigInput;
                $typeConfigInput->setName('type-config-'.strtolower($vp->getName()))
                    ->setAttribute('options', $vp->getConfigurationValues())
                    ->setAttribute('data-name', $vp->getName())
                    ->setLabel('type config');
            }
            $input = new SelectInput('type');
            $input->setLabel('type')
                ->setAttribute('options', $typeOptions);
            if ($property) $input->setValue($property->getValuesProvider()->getName());
            $form->add($input);

            foreach ($typeConfigs as $tc) $form->add($tc);
        }

        $form->setInputFilter($this->getModelInputFilter());

        return $form;
    }

    public function getModelInputFilter()
    {
        $factory = new FilterFactory();
        $filter = new InputFilter();
        $filter->add($factory->createInput(array(
            'name'     => 'name',
            'required' => true,
        )))->add($factory->createInput(array(
            'name'     => 'description',
            'required' => false,
        )))->add($factory->createInput(array(
            'name'     => 'type',
            'required' => false,
        )));

        return $filter;
    }

    public function canRemove(Property $property)
    {
        if (!$this->getEntityManager()->contains($property)) {
            return false;
        }

        return count($property->getTypeProperties()) == 0;
    }
}

<?php
// src/Locator/LocationBundle/Form/AddressType.php

namespace Locator\LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('address');
        $builder->add('distance');
        $builder->add('search', 'submit');
    }

    public function getName()
    {
        return 'address';
    }
}

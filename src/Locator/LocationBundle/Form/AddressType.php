<?php
// src/Locator/LocationBundle/Form/AddressType.php

namespace Locator\LocationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;

class AddressType extends AbstractType
{
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('address', new NotBlank());
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('address');
    }

    public function getName()
    {
        return 'address';
    }
}

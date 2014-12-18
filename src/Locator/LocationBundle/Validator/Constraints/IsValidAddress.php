<?php
// src/Locator/LocationBundle/Validator/Constraints/IsValidAddress.php

namespace Locator\LocationBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsValidAddress extends Constraint
{

    public $message = 'Not a valid address.';

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}

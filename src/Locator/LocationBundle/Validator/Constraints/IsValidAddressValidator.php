<?php
// src/Locator/LocationBundle/Validator/Constraints/IsValidAddressValidator.php

namespace Locator\LocationBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsValidAddressValidator extends ConstraintValidator
{
    public function validate($address, Constraint $constraint)
    {
        if (empty($address->getLatLng())) {
            // If you're using the new 2.5 validation API (you probably are!)
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}

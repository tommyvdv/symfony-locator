<?php

namespace Locator\LocationBundle\Utilities;

use Lexik\Bundle\TranslationBundle\Translation\Translator;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * AjaxResponse in Symfony
 *
 * @author Stef Bastiaansen <stef.bastiaansen@wijs.be>
 */
class FormErrors
{
    private $errors = array();

    /**
     * Return all errors of a form as an array which can be used in the
     * Javascript form.addErrors function in main.js
     *
     * @param \Symfony\Component\Form\Form $form
     * @param string $prefix
     * @return array
     */

    public function getMessages(\Symfony\Component\Form\Form $form, $prefix = '')
    {

        // walk all elements / forms recursively and add them to the same one-dimensional array
        foreach ($form->all() as $child) {
            if (!$child->isValid()) {

                $str = '';

                // should a field have more errors, concatenate with spaces
                foreach ($child->getErrors() as $key => $error) {
                    $str .= $error->getMessage() . ' ';
                }

                $this->errors[] = array(
                    $prefix . $form->getName() . '_' . $child->getName(),
                    $str
                );
                $this->getMessages($child, $form->getName() . '_');
            }
        }

        foreach ($form->getErrors() as $error) {
            if(!$error->getMessageParameters())
                $this->errors[] = array(null, $error->getMessage());
        }

        return $this->errors;
    }
}

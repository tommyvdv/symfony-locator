<?php

namespace Locator\LocationBundle\Utilities;

use Lexik\Bundle\TranslationBundle\Translation\Translator;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Custom AjaxResponse class
 * This class has every property of a normal (Json)Response
 * but it tries to fix the content of the data-property to a set of
 * four fields
 *  - error (false / string)
 *  - success (false / string)
 *  - fieldErrors (array with fieldnames/error messages)
 *  - data (array with custom data)
 *
 * @author Stef Bastiaansen <stef.bastiaansen@wijs.be>
 */
class AjaxResponse extends JsonResponse
{
    protected $translator;
    protected $unParsedData;

    /**
     * The class is uses as a service so messages can be translated
     *
     * @param Translator $translator
     */
    public function __construct(Translator $translator)
    {
        parent::__construct();

        $this->unParsedData = array(
            'error' => false,
            'success' => false,
            'fieldErrors' => array(),
            'data' => null
        );

        $this->translator = $translator;
    }

    /**
     * Set the success message with a label
     *
     * @param $message
     * @param string $domain
     */
    public function setSuccess($message, $domain = 'core')
    {
        $this->unParsedData['success'] = $this->translator->trans($message, array(), $domain);
    }

    /**
     * Set the error message with a label
     *
     * @param $message
     * @param string $domain
     */
    public function setError($message, $domain = 'core')
    {
        $this->unParsedData['error'] = $this->translator->trans($message, array(), $domain);
    }

    /**
     * Set the fieldErrors. They are NOT translated!
     *
     * @param array $fieldErrors
     */
    public function setFieldErrors($fieldErrors)
    {
        $this->unParsedData['fieldErrors'] = $fieldErrors;
    }

    /**
     * Add an extra field to the data array
     *
     * @param $key
     * @param $value
     */
    public function addData($key, $value)
    {
        $this->unParsedData['data'][$key] = $value;
    }

    public function addMassData($key, $data)
    {
        $this->unParsedData['data'][$key] = $data;
    }

    /**
     * Every AjaxResponse should be returned with return $response->parseData();!!!!
     *
     * @return $this
     */
    public function parseData()
    {
        $this->setData($this->unParsedData);
        return $this;
    }
}

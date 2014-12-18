<?php
// src/Locator/LocationBundle/Entity/Address.php

namespace Locator\LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

// validation
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\True;

// custom validation
use Locator\LocationBundle\Validator\Constraints\IsValidAddress;

class Address
{
    protected $address;
    protected $distance;
    protected $latlng;
    protected $geocoder;
    protected $valid;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        /*
        $metadata->addGetterConstraint('valid', new True(array(
            'message' => 'The address is invalid.',
        )));
        */
        $metadata->addConstraint(new IsValidAddress());
        $metadata->addPropertyConstraint('address', new NotBlank(array(
            'message' => 'Am i supposed to guess where you are?'
        )));
        $metadata->addPropertyConstraint('distance', new LessThanOrEqual(array(
            'value' => 40075,
            'message' => 'Considering 40075km takes you around the world, this number is just silly.'
        )));
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set address, and geocode
     *
     * @return string
     */
    public function setAddress($address, $geocode = true)
    {
        $this->address = $address;
        if ($geocode)
            $this->setLatLng($this->address);
    }

    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    public function getLatLng()
    {
        if(!$this->latlng) return array();
        return array_merge($this->latlng, array('distance' => $this->getDistance()));
    }

    private function setGeocoder()
    {
        // geocode
        $adapter  = new \Geocoder\HttpAdapter\CurlHttpAdapter();
        $this->geocoder = new \Geocoder\Geocoder();
        $this->geocoder->registerProvider(new \Geocoder\Provider\GoogleMapsProvider($adapter));
    }

    private function setLatLng($lookfor)
    {
        // setup geocoder
        $this->setGeocoder();

        try {
            // geocode
            $result = $this->geocoder->geocode($lookfor);

            // set result
            $this->latlng = array(
                'lat' => $result->getLatitude(),
                'lng' => $result->getLongitude()
            );
        } catch(\Exception $e) {
            $this->latlng = null;
        }
    }

    public function isValid()
    {
        if ($this->latlng !== null) {
            $this->valid = true;
        }
        $this->valid = false;

        return $this->valid;
    }
}

<?php
// src/Locator/LocationBundle/Entity/Address.php

namespace Locator\LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class Address
{
    protected $address;
    protected $latlng;

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
        $this->setLatLng($this->address);
    }

    public function getLatLng()
    {
        return $this->latlng;
    }

    private function setLatLng($lookfor)
    {
        // geocode
        $adapter  = new \Geocoder\HttpAdapter\CurlHttpAdapter();
        $geocoder = new \Geocoder\Geocoder();
        $geocoder->registerProvider(new \Geocoder\Provider\GoogleMapsProvider($adapter));

        $result = $geocoder->geocode($lookfor);

        $this->latlng = array('lat' => $result->getLatitude(), 'lng' => $result->getLongitude());
    }
}

<?php
// src/Locator/LocationBundle/Entity/Location.php

namespace Locator\LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Locator\LocationBundle\Entity\Repository\LocationRepository")
 * @ORM\Table(name="locations")
 * @ORM\HasLifecycleCallbacks
 */
class Location
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $street;

    /**
     * @ORM\Column(type="string")
     */
    protected $city;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=6)
     */
    protected $latitude;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=6)
     */
    protected $longitude;

    /**
     * @ORM\Column(type="string", length=1)
    */
    protected $is_open_in_weekends;

    /**
     * @ORM\Column(type="string", length=1)
    */
    protected $has_support_desk;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    protected $distance;


    public function __construct()
    {
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
       $this->setUpdated(new \DateTime());
    }

    /**
     * Set distance
     *
     * @param string $distance
     * @return Location
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * Get distance based on lat lng
     *
     * @return integer
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Get full address
     *
     * @return integer
     */
    public function getAddress()
    {
        return implode(" ", array(
                $this->street,
                $this->city
            )
        );
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Location
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Location
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return Location
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Location
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set is_open_in_weekends
     *
     * @param string $isOpenInWeekends
     * @return Location
     */
    public function setIsOpenInWeekends($isOpenInWeekends)
    {
        $this->is_open_in_weekends = $isOpenInWeekends;

        return $this;
    }

    /**
     * Get is_open_in_weekends
     *
     * @return string
     */
    public function getIsOpenInWeekends()
    {
        return $this->is_open_in_weekends;
    }

    /**
     * Set has_support_desk
     *
     * @param string $hasSupportDesk
     * @return Location
     */
    public function setHasSupportDesk($hasSupportDesk)
    {
        $this->has_support_desk = $hasSupportDesk;

        return $this;
    }

    /**
     * Get has_support_desk
     *
     * @return string
     */
    public function getHasSupportDesk()
    {
        return $this->has_support_desk;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Location
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Location
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}

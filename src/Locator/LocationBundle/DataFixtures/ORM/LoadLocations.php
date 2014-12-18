<?php
// src/Locator/LocationBundle/DataFixtures/ORM/LocationFixtures.php

namespace Locator\LocationBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\Yaml\Yaml;

use Locator\LocationBundle\Entity\Location;

class LoadLocations extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
     /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->loadLocations($manager);
    }

    private function loadLocations(ObjectManager $manager)
    {
        // load the yml file containing our fixtures
        $fixturesPath = dirname(__FILE__) . '/yml/locations.yml';
        $locations = Yaml::parse(file_get_contents($fixturesPath));

        foreach ($locations as $id => $locationData) {
            $location = new location();
            $location->setStreet($locationData['street']);
            $location->setCity($locationData['city']);
            $location->setLatitude($locationData['latitude']);
            $location->setLongitude($locationData['longitude']);
            $location->setIsOpenInWeekends($locationData['is_open_in_weekends']);
            $location->setHasSupportDesk($locationData['has_support_desk']);

            $manager->persist($location);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 200; // the order in which fixtures will be loaded
    }
}

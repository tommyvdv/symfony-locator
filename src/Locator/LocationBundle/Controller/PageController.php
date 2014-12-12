<?php
// src/Blogger/BlogBundle/Controller/PageController.php

namespace Locator\LocationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Locator\LocationBundle\Entity\Address;
use Locator\LocationBundle\Form\AddressType;

use Ivory\GoogleMap\Overlays\Animation;
use Ivory\GoogleMap\Overlays\Marker;

class PageController extends Controller
{
    public function indexAction()
    {
        // map
        $map = $this->get('ivory_google_map.map');

        // form
        $latlng = null;
        $address = new Address();
        $form = $this->createForm(new AddressType(), $address);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                // Perform some action, such as sending an email
                $latlng = $address->getLatLng();

                // center on lookup
                $map->setCenter($latlng['lat'], $latlng['lng'], true);
                $map->setMapOption('zoom', 10);
            }
        }

        // get all
        $em = $this->getDoctrine()
                   ->getEntityManager();

        $locations = $em->getRepository('LocatorLocationBundle:Location')
                    ->getAll(null, $latlng);

        foreach ($locations as $location)
        {
            $marker = new Marker();
            $marker->setPosition($location->getLatitude(), $location->getLongitude(), true);
            $marker->setAnimation(Animation::DROP);
            $marker->setOption('flat', true);

            $map->addMarker($marker);
        }

        // render
        return $this->render('LocatorLocationBundle:Page:index.html.twig', array(
            'locations' => $locations,
            'form' => $form->createView(),
            'map' => $map
        ));
    }
    public function aboutAction()
    {
        return $this->render('LocatorLocationBundle:Page:about.html.twig');
    }
    public function contactAction()
    {
        return $this->render('LocatorLocationBundle:Page:contact.html.twig');
    }
}

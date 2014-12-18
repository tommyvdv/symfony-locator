<?php
// src/Blogger/BlogBundle/Controller/PageController.php

namespace Locator\LocationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Locator\LocationBundle\Entity\Address;
use Locator\LocationBundle\Form\AddressType;

use Ivory\GoogleMap\Overlays\Animation;
use Ivory\GoogleMap\Overlays\Marker;
use Ivory\GoogleMap\Overlays\Circle;
use Ivory\GoogleMap\Controls\ZoomControl;
use Ivory\GoogleMap\Controls\ZoomControlStyle;
use Ivory\GoogleMap\Controls\ControlPosition;
use Ivory\GoogleMap\Controls\MapTypeControl;
use Ivory\GoogleMap\Controls\MapTypeControlStyle;
use Ivory\GoogleMap\MapTypeId;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
    public function ajaxAction(Request $request)
    {
        $response = $this->get('ajax_response');

        $address = new Address();

        $form = $this->createForm(new AddressType(), $address);
        $form->handleRequest($request);
//var_dump((string) $form->getErrors(true)); exit;
        if ($form->isValid())
        {
            $latlng = $address->getLatLng();

            // get all
            $em = $this->getDoctrine()
                       ->getEntityManager();

            $locations = $em->getRepository('LocatorLocationBundle:Location')
                        ->getAll(null, $latlng);

            $markers = array();
            foreach ($locations as $location)
            {
                $marker = new Marker();
                $marker->setPosition($location->getLatitude(), $location->getLongitude(), true);
                $marker->setAnimation(Animation::DROP);
                $marker->setOption('flat', true);

                $markers[] = array(
                    'id' => $location->getId(),
                    'label' => $marker->getJavascriptVariable(),
                    'lat' => $marker->getPosition()->getLatitude(),
                    'lng' => $marker->getPosition()->getLongitude()
                );
            }

            $response->addMassData('markers', $markers);
            //var_dump($markers); exit;

            $response->setSuccess('message.searchLocationsSuccess', 'locations');

        } else {

            $response->setFieldErrors($this->get('form_errors')->getMessages($form));

        }

        // return
        return $response->parseData();
    }

    public function indexAction()
    {
        // map
        $map = $this->get('ivory_google_map.map');
        $map->setJavascriptVariable('locator_google_map');

        $zoomControl = new ZoomControl();
        $zoomControl->setZoomControlStyle(ZoomControlStyle::SMALL);
        $map->setZoomControl($zoomControl);
        $map->setAutoZoom(true);

        $mapTypeControl = new MapTypeControl();
        $mapTypeControl->setMapTypeIds(array(MapTypeId::ROADMAP));
        $map->setMapTypeControl($mapTypeControl);

        // form
        $latlng = null;
        $address = new Address();
        $form = $this->createForm(new AddressType(), $address);
        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid())
            {
                if($address->isValid())
                {
                    // Perform some action, such as sending an email
                    $latlng = $address->getLatLng();

                    // draw radius
                    if ($latlng['distance'])
                    {
                        $circle = new Circle();
                        $circle->setCenter($latlng['lat'], $latlng['lng'], true);
                        $circle->setRadius($latlng['distance']*1000);
                        $circle->setOptions(array(
                            'clickable'    => false,
                            'strokeWeight' => 2,
                        ));
                        $map->addCircle($circle);
                    }

                    // center on lookup
                    $map->setCenter($latlng['lat'], $latlng['lng'], true);
                }
            }
        }

        // get all
        $em = $this->getDoctrine()
                   ->getEntityManager();

        $locations = $em->getRepository('LocatorLocationBundle:Location')
                    ->getAll(null, $latlng);

        if ($form->isValid())
        {
            if($address->isValid())
            {
                $numLocations = count($locations);
                $plural = count($locations) > 1 ? true : false;

                $format = 'You\'ve found %s location%s';
                $params = array($numLocations, $plural ? 's': '');

                if ($latlng['distance']) {
                    $format.= ' in a %s km radius';
                    $params[] = round($latlng['distance'], 2);
                }

                $format.= ' around \'%s\'.';
                $params[] = $address->getAddress();

                $this->get('session')->getFlashBag()->add(
                    'locator-notice',
                    vsprintf($format, $params)
                );
            }
        }

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
            )
        );
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

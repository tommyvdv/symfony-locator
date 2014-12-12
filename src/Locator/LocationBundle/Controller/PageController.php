<?php
// src/Blogger/BlogBundle/Controller/PageController.php

namespace Locator\LocationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Locator\LocationBundle\Entity\Address;
use Locator\LocationBundle\Form\AddressType;

class PageController extends Controller
{
    public function indexAction()
    {
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
            }
        }

        // get all
        $em = $this->getDoctrine()
                   ->getEntityManager();

        $locations = $em->getRepository('LocatorLocationBundle:Location')
                    ->getAll(null, $latlng);

        // render
        return $this->render('LocatorLocationBundle:Page:index.html.twig', array(
            'locations' => $locations,
            'form' => $form->createView()
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

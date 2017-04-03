<?php

namespace AppBundle\Controller\Front;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ServicesController extends Controller
{
    /**
     * @Route("/servicios", name="front_services")
     */
    public function servicesAction()
    {
        $services = $this->getDoctrine()->getRepository('AppBundle:Service')->findEnabledSortedByPosition();

        return $this->render(':Frontend:services_detail.html.twig', [
            'services' => $services,
        ]);
    }

//
//    /**
//     * @Route("/{slug}", name="front_service_detail")
//     */
//    public function detailServiceAction()
//    {
//        return $this->render(':Frontend:services_detail.html.twig');
//    }
}

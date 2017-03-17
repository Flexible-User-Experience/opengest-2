<?php

namespace AppBundle\Controller\Front;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="front_homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render(':Frontend:homepage.html.twig', array());
    }

    /**
     * @Route("/servicios", name="front_services")
     */
    public function servicesAction(Request $request)
    {
        return $this->render(':Frontend:services.html.twig', array());
    }

    /**
     * @Route("/vehiculos", name="front_vehicles")
     */
    public function vehiclesAction(Request $request)
    {
        return $this->render(':Frontend:vehicles.html.twig', array());
    }

    /**
     * @Route("/trabajos", name="front_works")
     */
    public function worksAction(Request $request)
    {
        return $this->render(':Frontend:works.html.twig', array());
    }

    /**
     * @Route("/empresa", name="front_company")
     */
    public function companyAction(Request $request)
    {
        return $this->render(':Frontend:company.html.twig', array());
    }
}

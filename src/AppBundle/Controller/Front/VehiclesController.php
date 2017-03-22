<?php

namespace AppBundle\Controller\Front;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class VehiclesController.
 */
class VehiclesController extends Controller
{
    /**
     * @Route("/vehiculos", name="front_vehicles")
     */
    public function vehiclesAction()
    {
        $vehicles = $this->getDoctrine()->getRepository('AppBundle:Vehicle')->findEnabledSortedByName();

        return $this->render(':Frontend:vehicles.html.twig', [
            'vehicles' => $vehicles,
        ]);
    }

    /**
     * @Route("/vehiculos/{slug}", name="front_vehicles_category")
     *
     * @param $slug
     *
     * @return Response
     */
    public function vehiclesCategoryAction($slug)
    {
        $vehicles = $this->getDoctrine()->getRepository('AppBundle:Vehicle')->findEnabledSortedByName();

        return $this->render(':Frontend:vehicles.html.twig', [
            'vehicles' => $vehicles,
        ]);
    }
}

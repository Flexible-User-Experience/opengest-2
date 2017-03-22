<?php

namespace AppBundle\Controller\Front;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class VehiclesController.
 */
class VehiclesController extends Controller
{
    /**
     * @Route("/nuestros-vehiculos", name="front_vehicles")
     */
    public function vehiclesAction()
    {
        $vehicles = $this->getDoctrine()->getRepository('AppBundle:Vehicle')->findEnabledSortedByName();

        return $this->render(':Frontend:vehicles.html.twig', [
            'vehicles' => $vehicles,
        ]);
    }
}

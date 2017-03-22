<?php

namespace AppBundle\Controller\Front;

use Doctrine\ORM\EntityNotFoundException;
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
     *
     * @throws EntityNotFoundException
     */
    public function vehiclesCategoryAction($slug)
    {
        $category = $this->getDoctrine()->getRepository('AppBundle:VehicleCategory')->findOneBy(['slug' => $slug]);

        if (!$category) {
            throw new EntityNotFoundException();
        }

        $vehicles = $this->getDoctrine()->getRepository('AppBundle:Vehicle')->findEnabledSortedByNameFilterCategory($category);

        return $this->render(':Frontend:vehicles.html.twig', [
            'vehicles' => $vehicles,
            'category' => $category,
        ]);
    }
}

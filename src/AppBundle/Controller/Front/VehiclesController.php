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
     * @Route("/vehiculos/{pagina}", name="front_vehicles")
     *
     * @param int $pagina
     *
     * @return Response
     */
    public function vehiclesAction($pagina = 1)
    {
        $vehicles = $this->getDoctrine()->getRepository('AppBundle:Vehicle')->findEnabledSortedByName();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($vehicles, $pagina, 9);

        return $this->render(':Frontend:vehicles.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/vehiculo/{slug}", name="front_vehicle_detail")
     *
     * @param $slug
     *
     * @return Response
     *
     * @throws EntityNotFoundException
     */
    public function vehicleDetailAction($slug)
    {
        $vehicle = $this->getDoctrine()->getRepository('AppBundle:Vehicle')->findOneBy(['slug' => $slug]);

        if (!$vehicle) {
            throw new EntityNotFoundException();
        }

        return $this->render(':Frontend:vehicle_detail.html.twig', [
            'vehicle' => $vehicle,
        ]);
    }

    /**
     * @Route("/vehiculos/categoria/{slug}", name="front_vehicles_category")
     *
     * @param $slug
     * @param int $pagina
     *
     * @return Response
     *
     * @throws EntityNotFoundException
     */
    public function vehiclesCategoryAction($slug, $pagina = 1)
    {
        $category = $this->getDoctrine()->getRepository('AppBundle:VehicleCategory')->findOneBy(['slug' => $slug]);

        if (!$category) {
            throw new EntityNotFoundException();
        }

        $vehicles = $this->getDoctrine()->getRepository('AppBundle:Vehicle')->findEnabledSortedByNameFilterCategory($category);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($vehicles, $pagina, 9);

        return $this->render(':Frontend:vehicles.html.twig', [
            'category' => $category,
            'pagination' => $pagination,
        ]);
    }
}

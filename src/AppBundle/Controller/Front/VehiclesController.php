<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\VehicleCategory;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class VehiclesController.
 */
class VehiclesController extends AbstractBaseController
{
    /**
     * @Route("/vehiculos", name="front_vehicles")
     *
     * @return RedirectResponse
     *
     * @throws EntityNotFoundException
     */
    public function vehiclesAction()
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:VehicleCategory')->findEnabledSortedByName();
        if (count($categories) == 0) {
            throw new EntityNotFoundException();
        }
        /** @var VehicleCategory $categoria */
        $categoria = $categories[0];

        return $this->redirectToRoute('front_vehicles_category', [
            'slug' => $categoria->getSlug(),
        ]);
    }

    /**
     * @Route("/vehiculo/{category_slug}/{slug}", name="front_vehicle_detail")
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
     * @Route("/vehiculos/categoria/{slug}/{page}", name="front_vehicles_category")
     *
     * @param $slug
     * @param int $page
     *
     * @return Response
     *
     * @throws EntityNotFoundException
     */
    public function vehiclesCategoryAction($slug, $page = 1)
    {
        $category = $this->getDoctrine()->getRepository('AppBundle:VehicleCategory')->findOneBy(['slug' => $slug]);

        if (!$category) {
            throw new EntityNotFoundException();
        }

        $vehicles = $this->getDoctrine()->getRepository('AppBundle:Vehicle')->findEnabledSortedByPositionAndName();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($vehicles, $page, AbstractBaseController::DEFAULT_PAGE_LIMIT);

        return $this->render(':Frontend:vehicles.html.twig', [
            'category' => $category,
            'pagination' => $pagination,
        ]);
    }
}

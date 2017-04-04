<?php

namespace AppBundle\Controller\Front;

use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * @Route("/servicios/{slug}", name="front_service_detail")
     *
     * @param $slug
     *
     * @return Response
     *
     * @throws EntityNotFoundException
     */
    public function detailServiceAction($slug)
    {
        $service = $this->getDoctrine()->getRepository('AppBundle:Service')->findOneBy(['slug' => $slug]);

        if ($service) {
            throw new EntityNotFoundException();
        }

        $services = $this->getDoctrine()->getRepository('AppBundle:Service')->findEnabledSortedByName();

        return $this->render(':Frontend:services_detail.html.twig', [
            'services' => $services,
        ]);
    }
}

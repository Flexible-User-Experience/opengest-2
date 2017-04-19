<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Service;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ServicesController extends Controller
{
    /**
     * @Route("/servicios", name="front_services")
     *
     * @return RedirectResponse
     *
     * @throws EntityNotFoundException
     */
    public function servicesAction()
    {
        $services = $this->getDoctrine()->getRepository('AppBundle:Service')->findEnabledSortedByPositionAndName();
        if (count($services) == 0) {
            throw new EntityNotFoundException();
        }
        /** @var Service $service */
        $service = $services[0];

        return $this->redirectToRoute('front_service_detail', [
            'slug' => $service->getSlug(),
        ]);
    }

    /**
     * @Route("/servicio/{slug}", name="front_service_detail")
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

        if (!$service) {
            throw new EntityNotFoundException();
        }

        return $this->render(':Frontend:services_detail.html.twig', [
            'service' => $service,
        ]);
    }
}

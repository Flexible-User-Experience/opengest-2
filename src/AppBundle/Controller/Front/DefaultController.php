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
    public function indexAction()
    {
        $service = $this->getDoctrine()->getRepository('AppBundle:Service')->findOneBy(['slug' => 'maniobrabilidad-reducida']);

        return $this->render(':Frontend:homepage.html.twig', array(
            'service' => $service,
        ));
    }

    /**
     * @Route("/empresa", name="front_company")
     */
    public function companyAction(Request $request)
    {
        return $this->render(':Frontend:company.html.twig', array());
    }
}

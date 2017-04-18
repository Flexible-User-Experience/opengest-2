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
        $serviceGC = $this->getDoctrine()->getRepository('AppBundle:Service')->findOneBy(['slug' => 'gruas-de-celosia']);
        $serviceGH = $this->getDoctrine()->getRepository('AppBundle:Service')->findOneBy(['slug' => 'gruas-hidraulicas']);
        $serviceMR = $this->getDoctrine()->getRepository('AppBundle:Service')->findOneBy(['slug' => 'maniobrabilidad-reducida']);

        return $this->render(':Frontend:homepage.html.twig', array(
            'serviceGC' => $serviceGC,
            'serviceGH' => $serviceGH,
            'serviceMR' => $serviceMR,
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

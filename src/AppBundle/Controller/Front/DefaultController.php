<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\ContactMessage;
use AppBundle\Form\ContactMessageForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     *
     * @param Request $request
     *
     * @return Response
     */
    public function companyAction(Request $request)
    {
        $contactMessage = new ContactMessage();
        $form = $this->createForm(ContactMessageForm::class, $contactMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Set frontend flash message
            $this->addFlash(
                'notice',
                'Tu mensaje se ha enviado correctamente'
            );
            // Persist new contact message into DB

            // Clean up new form
            $contactMessage = new ContactMessage();
            $form = $this->createForm(ContactMessageForm::class, $contactMessage);
        }

        return $this->render(':Frontend:company.html.twig', array(
            'contactForm' => $form->createView(),
        ));
    }
}

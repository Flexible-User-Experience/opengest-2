<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\ContactMessage;
use AppBundle\Entity\Service;
use AppBundle\Form\ContactMessageForm;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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
        if (0 == count($services)) {
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
     * @param Request $request
     * @param $slug
     *
     * @return Response
     *
     * @throws EntityNotFoundException
     */
    public function detailServiceAction(Request $request, $slug)
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
            $em = $this->getDoctrine()->getManager();
            $em->persist($contactMessage);
            $em->flush();
            // Send notification
            $messenger = $this->get('app.notification');
            $messenger->sendCommonUserNotification($contactMessage);
            $messenger->sendContactAdminNotification($contactMessage);
            // Clean up new form in production eviorament
            if ('prod' == $this->get('kernel')->getEnvironment()) {
                $contactMessage = new ContactMessage();
                $form = $this->createForm(ContactMessageForm::class, $contactMessage);
            }
        }

        $service = $this->getDoctrine()->getRepository('AppBundle:Service')->findOneBy(['slug' => $slug]);

        if (!$service) {
            throw new EntityNotFoundException();
        }

        return $this->render(':Frontend:services_detail.html.twig', [
            'service' => $service,
            'contactForm' => $form->createView(),
        ]);
    }
}

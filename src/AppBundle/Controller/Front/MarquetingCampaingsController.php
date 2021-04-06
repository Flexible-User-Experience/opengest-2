<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Web\ContactMessage;
use AppBundle\Form\ContactMessageForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class MarquetingCampaingsController.
 *
 * @category Controller
 */
class MarquetingCampaingsController extends Controller
{
    /**
     * @Route("/landing/plataformas-aereas-sobre-camion", name="front_landing_aerial_platforms")
     *
     * @param Request $request
     *
     * @return Response|RedirectResponse
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function landingAerialPlatformsAction(Request $request): Response
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

            // Go to monitored thanks page
            return $this->redirectToRoute('front_landing_aerial_platforms_thankyou');
        }

        return $this->render(':MarketingCampaings:aerial_platforms.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/landing/plataformas-aereas-sobre-camion/gracias", name="front_landing_aerial_platforms_thankyou")
     *
     * @return Response
     */
    public function landigAerialPlatformsThankyouAction(): Response
    {
        $contactMessage = new ContactMessage();
        $form = $this->createForm(ContactMessageForm::class, $contactMessage);

        return $this->render(':MarketingCampaings:aerial_platforms_thankyou.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}

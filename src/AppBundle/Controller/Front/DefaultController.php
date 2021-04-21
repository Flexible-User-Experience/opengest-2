<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Web\ContactMessage;
use AppBundle\Form\ContactMessageForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class DefaultController.
 *
 * @category Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="front_homepage")
     */
    public function indexAction(): Response
    {
        $serviceGC = $this->getDoctrine()->getRepository('AppBundle:Web\Service')->findOneBy(['slug' => 'gruas-de-celosia']);
        $serviceGH = $this->getDoctrine()->getRepository('AppBundle:Web\Service')->findOneBy(['slug' => 'gruas-hidraulicas']);
        $servicePA = $this->getDoctrine()->getRepository('AppBundle:Web\Service')->findOneBy(['slug' => 'plataformas-aereas-sobre-camion']);

        return $this->render(':Frontend:homepage.html.twig', array(
            'serviceGC' => $serviceGC,
            'serviceGH' => $serviceGH,
            'servicePA' => $servicePA,
        ));
    }

    /**
     * @Route("/empresa", name="front_company")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function companyAction(Request $request): Response
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
            // Clean up new form in production envioronment
            if ('prod' == $this->get('kernel')->getEnvironment()) {
                $contactMessage = new ContactMessage();
                $form = $this->createForm(ContactMessageForm::class, $contactMessage);
            }
        }

        return $this->render(':Frontend:company.html.twig', array(
            'contactForm' => $form->createView(),
        ));
    }

    /**
     * @Route("/sobre-este-sitio", name="front_about")
     */
    public function aboutAction(): Response
    {
        return $this->render(':Frontend:about.html.twig');
    }

    /**
     * @Route("/privacidad", name="front_privacy")
     */
    public function privacyAction(): Response
    {
        return $this->render(':Frontend:privacy.html.twig');
    }

    /**
     * @Route("/mapa-del-web", name="front_sitemap")
     */
    public function sitemapAction(): Response
    {
        return $this->render(':Frontend:sitemap.html.twig');
    }

    /**
     * @Route("/test-email", name="front_test_email")
     */
    public function testEmailAction(): Response
    {
        if ('prod' === $this->get('kernel')->getEnvironment()) {
            throw new HttpException(403);
        }
//        $entities = $this->get('app.repositories_manager')->getVehicleCheckingRepository()->getItemsInvalidByEnabledVehicle();
//        $contact = $this->getDoctrine()->getRepository(ContactMessage::class)->find(223);
        $contact = new ContactMessage();
        $contact
            ->setName('name 1')
            ->setAnswer('answer 1')
            ->setEmail('email 1')
            ->setPhone('phone 1')
            ->setMessage('message 1')
            ->setChecked(false)
            ->setAnswer(false)
        ;

        return $this->render(':Mails:common_user_notification.html.twig', array(
//            'entities' => $entities,
            'contact' => $contact,
            'show_devel_top_bar' => true,
        ));
    }
}

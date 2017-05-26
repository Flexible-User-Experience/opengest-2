<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\ContactMessage;
use AppBundle\Form\ContactMessageForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="front_homepage")
     */
    public function indexAction()
    {
        $serviceGC = $this->getDoctrine()->getRepository('AppBundle:Service')->findOneBy(['slug' => 'gruas-de-celosia']);
        $serviceGH = $this->getDoctrine()->getRepository('AppBundle:Service')->findOneBy(['slug' => 'gruas-hidraulicas']);
        $servicePA = $this->getDoctrine()->getRepository('AppBundle:Service')->findOneBy(['slug' => 'plataformas-aereas-sobre-camion']);

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
            $em = $this->getDoctrine()->getManager();
            $em->persist($contactMessage);
            $em->flush();
            // Send notification
            $messenger = $this->get('app.notification');
            $messenger->sendCommonUserNotification($contactMessage);
            $messenger->sendContactAdminNotification($contactMessage);
            // Clean up new form in production envioronment
            if ($this->get('kernel')->getEnvironment() == 'prod') {
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
    public function aboutAction()
    {
        return $this->render(':Frontend:about.html.twig');
    }

    /**
     * @Route("/privacidad", name="front_privacy")
     */
    public function privacyAction()
    {
        return $this->render(':Frontend:privacy.html.twig');
    }

    /**
     * @Route("/mapa-del-web", name="front_sitemap")
     */
    public function sitemapAction()
    {
        return $this->render(':Frontend:sitemap.html.twig');
    }

    /**
     * @Route("/test-email", name="front_test_email")
     *
     * @return Response
     *
     * @throws HttpException
     */
    public function testEmailAction()
    {
        if ($this->get('kernel')->getEnvironment() == 'prod') {
            throw new HttpException(403);
        }

        $contactMessage = new ContactMessage();
        $contactMessage
            ->setName('Manolito')
            ->setMessage('Grúa hidráulica todo terreno con capacidad máxima de 300TM.')
        ;
//        $contactMessage = $this->getDoctrine()->getRepository('AppBundle:ContactMessage')->find(1);

        return $this->render(':Mails:user_backend_answer_notification.html.twig', array(
            'contact' => $contactMessage,
        ));
    }
}

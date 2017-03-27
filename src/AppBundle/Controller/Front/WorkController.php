<?php
/**
 * Created by PhpStorm.
 * User: wils
 * Date: 27/3/17
 * Time: 11:47.
 */

namespace AppBundle\Controller\Front;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class WorkController extends Controller
{
    /**
     * @Route("/trabajos", name="front_works")
     *
     * @return Response
     */
    public function workAction()
    {
        $works = $this->getDoctrine()->getRepository('AppBundle:Work')->findEnabledSortedByName();

        return $this->render(':Frontend:works.html.twig', [
            'works' => $works,
        ]);
    }
}

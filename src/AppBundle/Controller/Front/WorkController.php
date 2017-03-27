<?php
/**
 * Created by PhpStorm.
 * User: wils
 * Date: 27/3/17
 * Time: 11:47.
 */

namespace AppBundle\Controller\Front;

use Doctrine\ORM\EntityNotFoundException;
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
    public function listAction()
    {
        $works = $this->getDoctrine()->getRepository('AppBundle:Work')->findEnabledSortedByName();

        return $this->render(':Frontend:works.html.twig', [
            'works' => $works,
        ]);
    }

    /**
     * @Route("/trabajo/{slug}", name="front_work_detail")
     *
     * @param $slug
     *
     * @return Response
     *
     * @throws EntityNotFoundException
     */
    public function detailAction($slug)
    {
        $work = $this->getDoctrine()->getRepository('AppBundle:Work')->findOneBy(['slug' => $slug]);

        if (!$work) {
            throw new EntityNotFoundException();
        }

        return $this->render(':Frontend:work_detail.html.twig', [
            'work' => $work,
        ]);
    }
}

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
     * @Route("/trabajos/{pagina}", name="front_works")
     *
     * @param int $pagina
     *
     * @return Response
     */
    public function listAction($pagina = 1)
    {
        $works = $this->getDoctrine()->getRepository('AppBundle:Work')->findEnabledSortedByName();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($works, $pagina, 9);

        return $this->render(':Frontend:works.html.twig', [
            'pagination' => $pagination,
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

        $images = $this->getDoctrine()->getRepository('AppBundle:WorkImage')->findEnabledSortedByPosition($work);

        return $this->render(':Frontend:work_detail.html.twig', [
            'work' => $work,
            'images' => $images,
        ]);
    }
}

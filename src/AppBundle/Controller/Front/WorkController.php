<?php

namespace AppBundle\Controller\Front;

use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class WorkController extends AbstractBaseController
{
    /**
     * @Route("/trabajos/{page}", name="front_works")
     *
     * @param int $page
     *
     * @return Response
     */
    public function listAction($page = 1)
    {
        $works = $this->getDoctrine()->getRepository('AppBundle:Work')->findEnabledSortedByName();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($works, $page, AbstractBaseController::DEFAULT_PAGE_LIMIT);

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
<?php

namespace AppBundle\Controller\Front;

use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ComplementController.
 *
 * @category Controller
 */
class ComplementController extends Controller
{
    /**
     * @Route("/accesorios", name="front_complement")
     */
    public function complementAction()
    {
        $complements = $this->getDoctrine()->getRepository('AppBundle:Web\Complement')->findEnabledSortedByName();

        return $this->render(':Frontend:complements.html.twig', [
            'complements' => $complements,
        ]);
    }

    /**
     * @Route("/accesorio/{slug}", name="front_complement_detail")
     *
     * @param $slug
     *
     * @return Response
     *
     * @throws EntityNotFoundException
     */
    public function complementDetailAction($slug)
    {
        $complement = $this->getDoctrine()->getRepository('AppBundle:Web\Complement')->findOneBy(['slug' => $slug]);
        if (!$complement) {
            throw new EntityNotFoundException();
        }

        return $this->render(':Frontend:complement_detail.html.twig', [
            'complement' => $complement,
        ]);
    }
}

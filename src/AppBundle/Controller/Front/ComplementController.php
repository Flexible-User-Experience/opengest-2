<?php

namespace AppBundle\Controller\Front;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class ComplementController.
 */
class ComplementController extends AbstractBaseController
{
    /**
     * @Route("/accesorios", name="front_complement")
     */
    public function complementAction()
    {
        $complements = $this->getDoctrine()->getRepository('AppBundle:Complement')->findEnabledSortedByName();

        return $this->render(':Frontend:complement.html.twig', [
            'complements' => $complements,
        ]);
    }
}

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
        return $this->render(':Frontend:complement.html.twig');
    }
}

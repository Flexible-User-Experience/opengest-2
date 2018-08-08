<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Enterprise;
use AppBundle\Security\EnterpriseVoter;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class BaseAdminController.
 *
 * @category Controller
 *
 * @author   David Romaní <david@flux.cat>
 */
abstract class BaseAdminController extends Controller
{
    /**
     * @param Request|null $request
     *
     * @return Request
     */
    protected function resolveRequest(Request $request = null)
    {
        if (null === $request) {
            return $this->getRequest();
        }

        return $request;
    }

    /**
     * @param array  $attributes
     * @param object $object
     */
    protected function denyAccessUnlessGranted($attributes, $object)
    {
        if ($object instanceof Enterprise) {
            /** @var EnterpriseVoter $voter */
            $voter = $this->container->get('app.voter_enterprise');

            if (VoterInterface::ACCESS_GRANTED !== $voter->vote($this->container->get('security.token_storage')->getToken(), $object, $attributes)) {
                throw new AccessDeniedException('Access denied');
            }
        }
    }
}

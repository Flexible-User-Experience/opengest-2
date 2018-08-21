<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\PartnerContact;
use AppBundle\Service\GuardService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PartnerContactAdminController.
 */
class PartnerContactAdminController extends BaseAdminController
{
    /**
     * @param null $id
     *
     * @return RedirectResponse|Response
     */
    public function editAction($id = null)
    {
        $request = $this->getRequest();
        $id = $request->get($this->admin->getIdParameter());

        /** @var PartnerContact $contact */
        $contact = $this->admin->getObject($id);
        if (!$contact) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }
        /** @var GuardService $guardService */
        $guardService = $this->container->get('app.guard_service');
        if (!$guardService->isOwnPartner($contact->getPartner())) {
            throw $this->createAccessDeniedException(sprintf('forbidden object with id: %s', $id));
        }

        return parent::editAction($id);
    }
}

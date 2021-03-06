<?php

namespace AppBundle\Controller\Admin\Partner;

use AppBundle\Controller\Admin\BaseAdminController;
use AppBundle\Entity\Partner\PartnerUnableDays;
use AppBundle\Service\GuardService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PartnerUnableDaysAdminController.
 */
class PartnerUnableDaysAdminController extends BaseAdminController
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

        /** @var PartnerUnableDays $partnerUnableDays */
        $partnerUnableDays = $this->admin->getObject($id);
        if (!$partnerUnableDays) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }
        /** @var GuardService $guardService */
        $guardService = $this->container->get('app.guard_service');
        if (!$guardService->isOwnPartner($partnerUnableDays->getPartner())) {
            throw $this->createAccessDeniedException(sprintf('forbidden object with id: %s', $id));
        }

        return parent::editAction($id);
    }
}

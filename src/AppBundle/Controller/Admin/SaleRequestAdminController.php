<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\SaleRequest;
use AppBundle\Service\GuardService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SaleRequestAdminController.
 */
class SaleRequestAdminController extends BaseAdminController
{
    /**
     * @param int|null $id
     *
     * @return RedirectResponse|Response
     */
    public function editAction($id = null)
    {
        $request = $this->getRequest();
        $id = $request->get($this->admin->getIdParameter());

        /** @var SaleRequest $saleRequest */
        $saleRequest = $this->admin->getObject($id);
        if (!$saleRequest) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }
        /** @var GuardService $guardService */
        $guardService = $this->container->get('app.guard_service');
        if (!$guardService->isOwnEnterprise($saleRequest->getEnterprise())) {
            throw $this->createNotFoundException(sprintf('forbidden object with id: %s', $id));
        }

        return parent::editAction($id);
    }
}

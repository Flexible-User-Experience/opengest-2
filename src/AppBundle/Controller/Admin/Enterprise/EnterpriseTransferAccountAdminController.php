<?php

namespace AppBundle\Controller\Admin\Enterprise;

use AppBundle\Controller\Admin\BaseAdminController;
use AppBundle\Entity\Enterprise\EnterpriseTransferAccount;
use AppBundle\Service\GuardService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EnterpriseTransferAccountAdminController.
 */
class EnterpriseTransferAccountAdminController extends BaseAdminController
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

        /** @var EnterpriseTransferAccount $enterpriseTransferAccount */
        $enterpriseTransferAccount = $this->admin->getObject($id);
        if (!$enterpriseTransferAccount) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }
        /** @var GuardService $guardService */
        $guardService = $this->container->get('app.guard_service');
        if (!$guardService->isOwnEnterprise($enterpriseTransferAccount->getEnterprise())) {
            throw $this->createNotFoundException(sprintf('forbidden object with id: %s', $id));
        }

        return parent::editAction($id);
    }
}

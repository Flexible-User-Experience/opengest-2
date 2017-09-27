<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Enterprise;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EnterpriseAdminController.
 */
class EnterpriseAdminController extends BaseAdminController
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

        /** @var Enterprise $enterprise */
        $enterprise = $this->admin->getObject($id);
        if (!$enterprise) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }

        $guardService = $this->get('app.guard_service');
        if (!$guardService->isOwnEnterprise($enterprise)) {
            throw $this->createNotFoundException(sprintf('forbidden object with id: %s', $id));
        }

        return parent::editAction($id);
    }
}
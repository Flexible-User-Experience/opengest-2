<?php

namespace AppBundle\Controller\Admin\Enterprise;

use AppBundle\Controller\Admin\BaseAdminController;
use AppBundle\Entity\Enterprise;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EnterpriseAdminController.
 */
class EnterpriseAdminController extends BaseAdminController
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

        /** @var Enterprise $enterprise */
        $enterprise = $this->admin->getObject($id);
        if (!$enterprise) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }
        /** GuardService $guardService */
        $guardService = $this->container->get('app.guard_service');
        if (!$guardService->isOwnEnterprise($enterprise)) {
            throw $this->createAccessDeniedException(sprintf('forbidden object with id: %s', $id));
        }

        return parent::editAction($id);
    }

    /**
     * @param int|null $id
     *
     * @return RedirectResponse
     */
    public function changeAction($id = null)
    {
        $request = $this->getRequest();
        $id = $request->get($this->admin->getIdParameter());

        /** @var Enterprise $enterprise */
        $enterprise = $this->admin->getObject($id);
        if (!$enterprise) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }

        /** @var User $user */
        $user = $this->getUser();
        $user->setDefaultEnterprise($enterprise);

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('sonata_admin_dashboard');
    }
}

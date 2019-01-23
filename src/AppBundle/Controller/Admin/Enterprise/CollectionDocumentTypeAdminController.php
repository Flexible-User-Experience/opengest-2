<?php

namespace AppBundle\Controller\Admin\Enterprise;

use AppBundle\Controller\Admin\BaseAdminController;
use AppBundle\Entity\Enterprise\CollectionDocumentType;
use AppBundle\Service\GuardService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CollectionDocumentTypeAdminController.
 */
class CollectionDocumentTypeAdminController extends BaseAdminController
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

        /** @var CollectionDocumentType $collectionDocumentType */
        $collectionDocumentType = $this->admin->getObject($id);
        if (!$collectionDocumentType) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }
        /** @var GuardService $guardService */
        $guardService = $this->container->get('app.guard_service');
        if (!$guardService->isOwnEnterprise($collectionDocumentType->getEnterprise())) {
            throw $this->createNotFoundException(sprintf('forbidden object with id: %s', $id));
        }

        return parent::editAction($id);
    }
}

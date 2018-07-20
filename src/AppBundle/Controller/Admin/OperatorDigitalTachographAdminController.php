<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\OperatorDigitalTachograph;
use AppBundle\Service\GuardService;

/**
 * Class OperatorDigitalTachographAdminController.
 */
class OperatorDigitalTachographAdminController extends BaseAdminController
{
    /**
     * @param null $id
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function downloadAction($id = null)
    {
        $request = $this->getRequest();
        $id = $request->get($this->admin->getIdParameter());

        /** @var OperatorDigitalTachograph $tachograph */
        $tachograph = $this->admin->getObject($id);
        if (!$tachograph) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }
        /** @var GuardService $guardService */
        $guardService = $this->container->get('app.guard_service');
        if (!$guardService->isOwnOperator($tachograph->getOperator())) {
            throw $this->createNotFoundException(sprintf('forbidden object with id: %s', $id));
        }

        $downloadHandler = $this->container->get('vich_uploader.download_handler');

        return $downloadHandler->downloadObject($tachograph, 'uploadedFile');
    }
}

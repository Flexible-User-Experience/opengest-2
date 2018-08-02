<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\VehicleDigitalTachograph;
use AppBundle\Service\GuardService;

/**
 * Class VehicleDigitalTachographAdminController.
 */
class VehicleDigitalTachographAdminController extends BaseAdminController
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

        /** @var VehicleDigitalTachograph $tachograph */
        $tachograph = $this->admin->getObject($id);
        if (!$tachograph) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }

        /** @var GuardService $guardService */
        $guardService = $this->container->get('app.guard_service');
        if (!$guardService->isOwnVehicle($tachograph->getVehicle())) {
            throw $this->createNotFoundException(sprintf('forbidden object with id: %s', $id));
        }

        $downloadHandler = $this->container->get('vich_uploader.download_handler');

        return $downloadHandler->downloadObject($tachograph, 'uploadedFile');
    }
}

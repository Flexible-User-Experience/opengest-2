<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Vich\UploaderBundle\Handler\DownloadHandler;

/**
 * Class DigitalTachographAdminController.
 */
class DigitalTachographAdminController extends BaseAdminController
{
//    /**
//     * @param null $id
//     *
//     * @return RedirectResponse|Response
//     */
//    public function editAction($id = null)
//    {
//        $request = $this->getRequest();
//        $id = $request->get($this->admin->getIdParameter());
//
//        /** @var Vehicle $vehicle */
//        $vehicle = $this->admin->getObject($id);
//        if (!$vehicle) {
//            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
//        }
//
//        $guardService = $this->get('app.guard_service');
//        if (!$guardService->isOwnVehicle($vehicle)) {
//            throw $this->createNotFoundException(sprintf('forbidden object with id: %s', $id));
//        }
//
//        return parent::editAction($id);
//    }

    /**
     * @param null            $id
     * @param DownloadHandler $downloadHandler
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function downloadAction($id = null, DownloadHandler $downloadHandler)
    {
        $request = $this->getRequest();
        $id = $request->get($this->admin->getIdParameter());

        $tachograph = $this->admin->getObject($id);

        return $downloadHandler->downloadObject($tachograph, $fileField = 'uploadedFileName');
    }
}

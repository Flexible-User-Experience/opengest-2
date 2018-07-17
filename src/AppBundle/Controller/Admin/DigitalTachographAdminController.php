<?php

namespace AppBundle\Controller\Admin;

/**
 * Class DigitalTachographAdminController.
 */
class DigitalTachographAdminController extends BaseAdminController
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

        $tachograph = $this->admin->getObject($id);
        if (!$tachograph) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }

        $guardService = $this->container->get('app.guard_service');
        if (!$guardService->isOwnTachograph($tachograph)) {
            throw $this->createNotFoundException(sprintf('forbidden object with id: %s', $id));
        }

        $downloadHandler = $this->container->get('vich_uploader.download_handler');

        return $downloadHandler->downloadObject($tachograph, 'uploadedFile');
    }
}

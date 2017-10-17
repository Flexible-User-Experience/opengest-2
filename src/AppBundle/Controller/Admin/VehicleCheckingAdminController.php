<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\VehicleChecking;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class VehicleCheckingAdminController.
 */
class VehicleCheckingAdminController extends BaseAdminController
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

        /** @var VehicleChecking $vehicleChecking */
        $vehicleChecking = $this->admin->getObject($id);
        if (!$vehicleChecking) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }

        $guardService = $this->get('app.guard_service');
        if (!$guardService->isOwnVehicleChecking($vehicleChecking)) {
            throw $this->createNotFoundException(sprintf('forbidden object with id: %s', $id));
        }

        return parent::editAction($id);
    }
}

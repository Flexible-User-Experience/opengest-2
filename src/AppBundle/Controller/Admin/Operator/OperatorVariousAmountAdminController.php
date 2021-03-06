<?php

namespace AppBundle\Controller\Admin\Operator;

use AppBundle\Controller\Admin\BaseAdminController;
use AppBundle\Entity\Operator\OperatorVariousAmount;
use AppBundle\Service\GuardService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OperatorVariousAmountAdminController.
 */
class OperatorVariousAmountAdminController extends BaseAdminController
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

        /** @var OperatorVariousAmount $operatorVariousAmount */
        $operatorVariousAmount = $this->admin->getObject($id);
        if (!$operatorVariousAmount) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }
        /** @var GuardService $guardService */
        $guardService = $this->container->get('app.guard_service');
        if (!$guardService->isOwnOperator($operatorVariousAmount->getOperator())) {
            throw $this->createAccessDeniedException(sprintf('forbidden object with id: %s', $id));
        }

        return parent::editAction($id);
    }
}

<?php

namespace AppBundle\Controller\Admin\Sale;

use AppBundle\Controller\Admin\BaseAdminController;
use AppBundle\Entity\Sale\SaleRequest;
use AppBundle\Manager\Pdf\SaleRequestPdfManager;
use AppBundle\Service\GuardService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class SaleRequestAdminController.
 */
class SaleRequestAdminController extends BaseAdminController
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

        /** @var SaleRequest $saleRequest */
        $saleRequest = $this->admin->getObject($id);
        if (!$saleRequest) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }
        /** @var GuardService $guardService */
        $guardService = $this->container->get('app.guard_service');
        if (!$guardService->isOwnEnterprise($saleRequest->getEnterprise())) {
            throw $this->createNotFoundException(sprintf('forbidden object with id: %s', $id));
        }

        return parent::editAction($id);
    }

    /**
     * Generate PDF receipt action.
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws NotFoundHttpException If the object does not exist
     * @throws AccessDeniedException If access is not granted
     */
    public function pdfAction(Request $request)
    {
        $request = $this->resolveRequest($request);
        $id = $request->get($this->admin->getIdParameter());

        /** @var SaleRequest $object */
        $saleRequest = $this->admin->getObject($id);
        if (!$saleRequest) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }

        /** @var SaleRequestPdfManager $rps */
        $rps = $this->container->get('app.sale_request_pdf_manager');

        return new Response($rps->output($saleRequest), 200, array('Content-type' => 'application/pdf'));
    }
}

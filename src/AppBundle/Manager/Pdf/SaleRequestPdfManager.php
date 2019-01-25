<?php

namespace AppBundle\Manager\Pdf;

use AppBundle\Entity\Sale\SaleRequest;
use AppBundle\Service\PdfEngineService;

/**
 * Class SaleRequestPdfManager.
 *
 * @category Manager
 */
class SaleRequestPdfManager
{
    /**
     * @var PdfEngineService
     */
    private $pdfEngineService;

    /**
     * Methods.
     */

    /**
     * SaleRequestPdfManager constructor.
     *
     * @param PdfEngineService $pdfEngineService
     */
    public function __construct(PdfEngineService $pdfEngineService)
    {
        $this->pdfEngineService = $pdfEngineService;
    }

    /**
     * @param SaleRequest $saleRequest
     *
     * @return \TCPDF
     */
    public function build(SaleRequest $saleRequest)
    {
        $this->pdfEngineService->initDefaultPageEngineWithTitle($saleRequest);
        $pdf = $this->pdfEngineService->getEngine();

        // add start page
        $pdf->AddPage(PDF_PAGE_ORIENTATION, PDF_PAGE_FORMAT, true, true);

        return $pdf;
    }

    /**
     * @param SaleRequest $saleRequest
     *
     * @return string
     */
    public function output(SaleRequest $saleRequest)
    {
        $pdf = $this->build($saleRequest);

        return $pdf->Output('peticion_'.$saleRequest->getId().'.pdf', 'I');
    }
}

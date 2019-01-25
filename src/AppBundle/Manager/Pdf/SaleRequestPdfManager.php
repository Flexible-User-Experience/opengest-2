<?php

namespace AppBundle\Manager\Pdf;

use AppBundle\Entity\Sale\SaleRequest;
use AppBundle\Enum\ConstantsEnum;
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
        $pdf->AddPage(ConstantsEnum::PDF_PORTRAIT_PAGE_ORIENTATION, ConstantsEnum::PDF_PAGE_A5);
        $pdf->SetFont('FreeSerif', 'I', 9);

        $height_cell = 6;
        $margin_left = 10;
        $width = 70;
        $total = $width + $margin_left;

        $pdf->setY(5);
        $pdf->setX($margin_left + $width);

        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(20, $height_cell, 'GRUA Nº', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(40, $height_cell, $saleRequest->getVehicle(), 0, 1, 'L');

        $pdf->setX($margin_left + $width);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(20, $height_cell, 'TM', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(40, $height_cell, $saleRequest->getTariff()->getTonnage(), 0, 1, 'L');

        $pdf->setX($margin_left + $width);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(20, $height_cell, 'CHOFER', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(40, $height_cell, $saleRequest->getOperator()->getShortFullName(), 0, 1, 'L');

        $pdf->setX($margin_left);
        $this->pdfEngineService->setStyleSize('B', 10);
        $pdf->Cell(20, $height_cell, 'PETICIÓN DE SERVICIO', 0, 1, 'L');

        $pdf->setX($margin_left);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(20, $height_cell, 'Fecha:', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(40, $height_cell, $saleRequest->getServiceDateString(), 0, 1, 'L');

        $pdf->setX($margin_left);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(20, $height_cell, 'EMPRESA', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(40, $height_cell, substr($saleRequest->getPartner()->getName(), 0, 34), 0, 0, 'L');

        $pdf->setX($margin_left + $width + 20);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(10, $height_cell, 'SR.', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(40, $height_cell, $saleRequest->getContactPersonName(), 0, 1, 'L');

        $pdf->setX($margin_left);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(20, $height_cell, 'POBLACIÓN', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(40, $height_cell, substr($saleRequest->getPartner()->getMainCityName(), 0, 30), 0, 0, 'L');

        $pdf->setX($margin_left + $width + 20);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(10, $height_cell, 'TELF', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(40, $height_cell, $saleRequest->getPartner()->getPhoneNumber1(), 0, 1, 'L');

        $pdf->setX($margin_left);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(20, $height_cell, 'DIRECCIÓN', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(40, $height_cell, $saleRequest->getPartner()->getMainAddress(), 0, 1, 'L');

        $pdf->setX($margin_left);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(20, $height_cell, 'C.I.F.', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell($margin_left + $width - 20, $height_cell, $saleRequest->getPartner()->getCifNif(), 0, 0, 'L');

        $pdf->setX($margin_left + $width);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(20, $height_cell, 'F.PAGO', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(40, $height_cell, $saleRequest->getPartner()->getClass()->getName(), 0, 1, 'L'); // TODO not reading properly attribute

        $pdf->setX($margin_left);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(20, $height_cell, 'BANCO', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(40, $height_cell, '', 0, 1, 'L');

        $pdf->ln(4);
        $pdf->Line($margin_left, $pdf->getY(), $margin_left + $width + 60, $pdf->getY());
        $pdf->ln(4);

        $pdf->setX($margin_left);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(40, $height_cell, 'TRABAJO A REALIZAR', 0, 1, 'L');

        $pdf->setX($margin_left);
        $this->pdfEngineService->setStyleSize('', 9);
        $y = $pdf->GetY();
        $pdf->MultiCell($total + 50, $height_cell, $saleRequest->getServiceDescription(), 0, 'L');
        $pdf->setY($y + 6 * $height_cell);

        $pdf->setX($margin_left);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(20, $height_cell, 'ALTURA', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(20, $height_cell, $saleRequest->getHeight(), 0, 0, 'L');

        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(20, $height_cell, 'DISTANCIA', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(20, $height_cell, $saleRequest->getDistance(), 0, 0, 'L');

        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(20, $height_cell, 'PESO', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(20, $height_cell, $saleRequest->getWeight(), 0, 1, 'L');

        $pdf->setX($margin_left);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(40, $height_cell, 'LUGAR DE TRABAJO', 0, 1, 'L');

        $pdf->setX($margin_left);
        $this->pdfEngineService->setStyleSize('', 9);
        $y = $pdf->GetY();
        $pdf->MultiCell($total + 50, $height_cell, $saleRequest->getPlace(), 0, 'L');
        $pdf->setY($y + 3 * $height_cell);

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

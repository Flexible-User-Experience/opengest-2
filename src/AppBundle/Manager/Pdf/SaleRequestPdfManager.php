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
        $pdf->SetFont(ConstantsEnum::PDF_DEFAULT_FONT, '', 9);
        $width = 70;
        $total = $width + ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT;

        // logo
        $pdf->Image($this->pdfEngineService->getSmartAssetsHelper()->getAbsoluteAssetFilePath('/bundles/app/img/logo_romani.png'), ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT, 5, 30); // TODO replace by enterprise image if defined

        // operator
        $pdf->setXY($total, 5);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(16, ConstantsEnum::PDF_CELL_HEIGHT, 'GRUA Nº', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(43, ConstantsEnum::PDF_CELL_HEIGHT, $saleRequest->getVehicle(), 0, 0, 'L');
        $pdf->Cell(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT, ConstantsEnum::PDF_CELL_HEIGHT, '', 0, 1, 'L', true);

        $pdf->setX($total);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(16, ConstantsEnum::PDF_CELL_HEIGHT, 'TM', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(43, ConstantsEnum::PDF_CELL_HEIGHT, $saleRequest->getTariff()->getTonnage(), 0, 0, 'L');
        $pdf->Cell(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT, ConstantsEnum::PDF_CELL_HEIGHT, '', 0, 1, 'L', true);

        $pdf->setX($total);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(16, ConstantsEnum::PDF_CELL_HEIGHT, 'CHOFER', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(43, ConstantsEnum::PDF_CELL_HEIGHT, $saleRequest->getOperator()->getFullName(), 0, 0, 'L');
        $pdf->Cell(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT, ConstantsEnum::PDF_CELL_HEIGHT, '', 0, 1, 'L', true);

        // heading title
        $pdf->Ln(ConstantsEnum::PDF_CELL_HEIGHT);
        $pdf->setX(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT);
        $this->pdfEngineService->setStyleSize('B', 14);
        $pdf->Cell(168, ConstantsEnum::PDF_CELL_HEIGHT, 'PETICIÓN DE SERVICIO', 0, 1, 'L');
        $pdf->Ln(ConstantsEnum::PDF_CELL_HEIGHT);

        // customer
        $pdf->setX(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(22, ConstantsEnum::PDF_CELL_HEIGHT, 'FECHA', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(106, ConstantsEnum::PDF_CELL_HEIGHT, $saleRequest->getServiceDateString(), 0, 0, 'L');
        $pdf->Cell(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT, ConstantsEnum::PDF_CELL_HEIGHT, '', 0, 1, 'L', true);

        $pdf->setX(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(22, ConstantsEnum::PDF_CELL_HEIGHT, 'EMPRESA', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(40, ConstantsEnum::PDF_CELL_HEIGHT, substr($saleRequest->getPartner()->getName(), 0, 34), 0, 0, 'L');
        $pdf->setX(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT + $width + 20);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(12, ConstantsEnum::PDF_CELL_HEIGHT, 'SR.', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(26, ConstantsEnum::PDF_CELL_HEIGHT, $saleRequest->getContactPersonName(), 0, 0, 'L');
        $pdf->Cell(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT, ConstantsEnum::PDF_CELL_HEIGHT, '', 0, 1, 'L', true);

        $pdf->setX(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(22, ConstantsEnum::PDF_CELL_HEIGHT, 'POBLACIÓN', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(40, ConstantsEnum::PDF_CELL_HEIGHT, substr($saleRequest->getPartner()->getMainCityName(), 0, 30), 0, 0, 'L');
        $pdf->setX(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT + $width + 20);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(12, ConstantsEnum::PDF_CELL_HEIGHT, 'TELF.', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(26, ConstantsEnum::PDF_CELL_HEIGHT, $saleRequest->getPartner()->getPhoneNumber1(), 0, 0, 'L');
        $pdf->Cell(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT, ConstantsEnum::PDF_CELL_HEIGHT, '', 0, 1, 'L', true);

        $pdf->setX(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(20, ConstantsEnum::PDF_CELL_HEIGHT, 'DIRECCIÓN', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(40, ConstantsEnum::PDF_CELL_HEIGHT, $saleRequest->getPartner()->getMainAddress(), 0, 1, 'L');

        $pdf->setX(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(20, ConstantsEnum::PDF_CELL_HEIGHT, 'C.I.F.', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT + $width - 20, ConstantsEnum::PDF_CELL_HEIGHT, $saleRequest->getPartner()->getCifNif(), 0, 0, 'L');

        $pdf->setX(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT + $width);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(20, ConstantsEnum::PDF_CELL_HEIGHT, 'F.PAGO', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(40, ConstantsEnum::PDF_CELL_HEIGHT, $saleRequest->getPartner()->getClass()->getName(), 0, 1, 'L'); // TODO not reading properly attribute

//        $pdf->setX(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT);
//        $this->pdfEngineService->setStyleSize('B', 9);
//        $pdf->Cell(20, ConstantsEnum::PDF_CELL_HEIGHT, 'BANCO', 0, 0, 'L');
//        $this->pdfEngineService->setStyleSize('', 9);
//        $pdf->Cell(40, ConstantsEnum::PDF_CELL_HEIGHT, '', 0, 1, 'L');

        // draw horitzontal line separator
        $this->drawHoritzontalLineSeparator($pdf);

        $pdf->setX(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(40, ConstantsEnum::PDF_CELL_HEIGHT, 'TRABAJO A REALIZAR', 0, 1, 'L');

        $pdf->setX(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT);
        $this->pdfEngineService->setStyleSize('', 9);
        $y = $pdf->GetY();
        $pdf->MultiCell($total + 50, ConstantsEnum::PDF_CELL_HEIGHT, $saleRequest->getServiceDescription(), 0, 'L');
        $pdf->setY($y + 6 * ConstantsEnum::PDF_CELL_HEIGHT);

        $pdf->setX(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(15, ConstantsEnum::PDF_CELL_HEIGHT, 'ALTURA', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(35, ConstantsEnum::PDF_CELL_HEIGHT, $saleRequest->getHeightString(), 0, 0, 'L');

        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(20, ConstantsEnum::PDF_CELL_HEIGHT, 'DISTANCIA', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(20, ConstantsEnum::PDF_CELL_HEIGHT, $saleRequest->getDistanceString(), 0, 0, 'L');

        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(10, ConstantsEnum::PDF_CELL_HEIGHT, 'PESO', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(20, ConstantsEnum::PDF_CELL_HEIGHT, $saleRequest->getWeight(), 0, 1, 'L');

        $pdf->setX(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(40, ConstantsEnum::PDF_CELL_HEIGHT, 'LUGAR DE TRABAJO', 0, 1, 'L');

        $pdf->setX(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT);
        $this->pdfEngineService->setStyleSize('', 9);
        $y = $pdf->GetY();
        $pdf->MultiCell($total + 50, ConstantsEnum::PDF_CELL_HEIGHT, $saleRequest->getPlace(), 0, 'L');
        $pdf->setY($y + 3 * ConstantsEnum::PDF_CELL_HEIGHT);

        // draw horitzontal line separator
        $this->drawHoritzontalLineSeparator($pdf);

        $pdf->setX(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(13, ConstantsEnum::PDF_CELL_HEIGHT, 'HORA', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(17, ConstantsEnum::PDF_CELL_HEIGHT, $saleRequest->getServiceTimeString(), 0, 0, 'L');

        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(10, ConstantsEnum::PDF_CELL_HEIGHT, 'DIA', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(20, ConstantsEnum::PDF_CELL_HEIGHT, $saleRequest->getServiceDateString(), 0, 0, 'L');

        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(20, ConstantsEnum::PDF_CELL_HEIGHT, 'MÍNIMO H.', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(15, ConstantsEnum::PDF_CELL_HEIGHT, $saleRequest->getMiniumHours(), 0, 0, 'L');

        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(20, ConstantsEnum::PDF_CELL_HEIGHT, 'PRECIO H.', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(15, ConstantsEnum::PDF_CELL_HEIGHT, $saleRequest->getHourPrice(), 0, 1, 'L');

        $pdf->setX(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(35, ConstantsEnum::PDF_CELL_HEIGHT, 'DESPLAZAMIENTO', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(5, ConstantsEnum::PDF_CELL_HEIGHT, $saleRequest->getDisplacement(), 0, 0, 'L');

        $pdf->setX(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT + $width + 16);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(25, ConstantsEnum::PDF_CELL_HEIGHT, 'ATENDIDO POR', 0, 0, 'L');
        $user = $saleRequest->getAttendedBy();
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(15, ConstantsEnum::PDF_CELL_HEIGHT, strtoupper($user->getUsername()), 0, 1, 'L');

        $pdf->setX(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(40, ConstantsEnum::PDF_CELL_HEIGHT, 'OBSERVACIONES', 0, 1, 'L');

        $this->pdfEngineService->setStyleSize('', 9);
        if ($saleRequest->getUtensils()) {
            $pdf->setX(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT);
            $pdf->Cell($total + 50, ConstantsEnum::PDF_CELL_HEIGHT, $saleRequest->getUtensils(), 0, 1, 'L');
        }

        $pdf->setX(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT);
        $pdf->MultiCell(ConstantsEnum::PDF_PAGE_A5_MARGIN_LEFT + $width + 50, ConstantsEnum::PDF_CELL_HEIGHT, $saleRequest->getObservations(), 0, 'L');

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

    /**
     * @param \TCPDF $pdf
     * @param int    $marginLeft
     */
    private function drawHoritzontalLineSeparator(\TCPDF $pdf, $marginLeft = 10)
    {
        $pdf->ln(4);
        $pdf->Line($marginLeft, $pdf->getY(), 149 - $marginLeft, $pdf->getY());
        $pdf->ln(4);
    }
}

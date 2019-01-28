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

        $pdf->Ln($height_cell);
        $pdf->setX($margin_left);
        $this->pdfEngineService->setStyleSize('B', 14);
        $pdf->Cell(20, $height_cell, 'PETICIÓN DE SERVICIO', 0, 1, 'L');

        $pdf->Ln($height_cell);
        $pdf->setX($margin_left);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(20, $height_cell, 'FECHA', 0, 0, 'L');
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
        $pdf->Cell(10, $height_cell, 'TELF.', 0, 0, 'L');
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

//        $pdf->setX($margin_left);
//        $this->pdfEngineService->setStyleSize('B', 9);
//        $pdf->Cell(20, $height_cell, 'BANCO', 0, 0, 'L');
//        $this->pdfEngineService->setStyleSize('', 9);
//        $pdf->Cell(40, $height_cell, '', 0, 1, 'L');

        // draw horitzontal line separator
        $this->drawHoritzontalLineSeparator($pdf);

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
        $pdf->Cell(15, $height_cell, 'ALTURA', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(35, $height_cell, $saleRequest->getHeightString(), 0, 0, 'L');

        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(20, $height_cell, 'DISTANCIA', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(20, $height_cell, $saleRequest->getDistanceString(), 0, 0, 'L');

        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(10, $height_cell, 'PESO', 0, 0, 'L');
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

        // draw horitzontal line separator
        $this->drawHoritzontalLineSeparator($pdf);

        $pdf->setX($margin_left);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(13, $height_cell, 'HORA', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(17, $height_cell, $saleRequest->getServiceTimeString(), 0, 0, 'L');

        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(10, $height_cell, 'DIA', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(20, $height_cell, $saleRequest->getServiceDateString(), 0, 0, 'L');

        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(20, $height_cell, 'MÍNIMO H.', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(15, $height_cell, $saleRequest->getMiniumHours(), 0, 0, 'L');

        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(20, $height_cell, 'PRECIO H.', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(15, $height_cell, $saleRequest->getHourPrice(), 0, 1, 'L');

        $pdf->setX($margin_left);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(35, $height_cell, 'DESPLAZAMIENTO', 0, 0, 'L');
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(5, $height_cell, $saleRequest->getDisplacement(), 0, 0, 'L');

        $pdf->setX($margin_left + $width + 16);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(25, $height_cell, 'ATENDIDO POR', 0, 0, 'L');
        $user = $saleRequest->getAttendedBy();
        $this->pdfEngineService->setStyleSize('', 9);
        $pdf->Cell(15, $height_cell, strtoupper($user->getUsername()), 0, 1, 'L');

        $pdf->setX($margin_left);
        $this->pdfEngineService->setStyleSize('B', 9);
        $pdf->Cell(40, $height_cell, 'OBSERVACIONES', 0, 1, 'L');

        $this->pdfEngineService->setStyleSize('', 9);
        if ($saleRequest->getUtensils()) {
            $pdf->setX($margin_left);
            $pdf->Cell($total + 50, $height_cell, $saleRequest->getUtensils(), 0, 1, 'L');
        }

        $pdf->setX($margin_left);
        $pdf->MultiCell($margin_left + $width + 50, $height_cell, $saleRequest->getObservations(), 0, 'L');

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

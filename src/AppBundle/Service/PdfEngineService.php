<?php

namespace AppBundle\Service;

use AppBundle\Enum\ConstantsEnum;

/**
 * PdfEngineService CourierService.
 *
 * @category Service
 *
 * @author   David Romaní <david@flux.cat>
 */
class PdfEngineService
{
    /**
     * @var \TCPDF
     */
    private $engine;

    /**
     * @var SmartAssetsHelperService
     */
    private $sahs;

    /**
     * @var string
     */
    private $author;

    /**
     * @var string
     */
    private $subject;

    /**
     * Methods.
     */

    /**
     * Constructor.
     *
     * @param SmartAssetsHelperService $sahs
     * @param string                   $author
     * @param string                   $subject
     */
    public function __construct(SmartAssetsHelperService $sahs, $author, $subject)
    {
        $this->engine = new \TCPDF();
        $this->sahs = $sahs;
        $this->author = $author;
        $this->subject = $subject;
    }

    /**
     * @return \TCPDF|null
     */
    public function getEngine(): \TCPDF
    {
        return $this->engine;
    }

    /**
     * @return SmartAssetsHelperService|null
     */
    public function getSmartAssetsHelper(): SmartAssetsHelperService
    {
        return $this->sahs;
    }

    /**
     * @param string $title
     * @param string $orientation
     * @param string $units
     *
     * @return \TCPDF
     */
    public function initPageEngine($title, $orientation = ConstantsEnum::PDF_PORTRAIT_PAGE_ORIENTATION, $units = ConstantsEnum::PDF_PAGE_UNITS)
    {
        // page settings
        $this->engine->setPageOrientation($orientation);
        $this->engine->setPageUnit($units);

        // set document information
        $this->engine->SetCreator(PDF_CREATOR);
        $this->engine->SetAuthor($this->author);
        $this->engine->SetTitle($title);
        $this->engine->SetSubject($this->subject);
        $this->engine->SetKeywords('TCPDF, PDF, '.$this->author);

        // set default monospaced font
        $this->engine->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $this->engine->SetMargins(0, 0, 0);
        $this->engine->SetHeaderMargin(0);
        $this->engine->SetFooterMargin(0);

        // set headers
        $this->engine->setPrintHeader(false);
        $this->engine->setPrintFooter(false);

        // set auto page breaks
        $this->engine->SetAutoPageBreak(true, 0);

        // set image scale factor
        $this->engine->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set default font subsetting mode
        $this->engine->setFontSubsetting(true);

        // set font
        $this->engine->SetFont('dejavusans', '', 14, '', true);

        // set cell settings
        $this->engine->SetFillColor(255);
        if ($this->sahs->isDevelEnvironment()) {
            $this->engine->SetFillColor(200);
        }

        $this->engine->setCellMargins(0, 0, 0, 0);
        $this->engine->SetCellPadding(0);

        return $this->engine;
    }

    /**
     * @param string $title
     *
     * @return \TCPDF
     */
    public function initDefaultPageEngineWithTitle($title)
    {
        $this->initPageEngine($title);

        return $this->engine;
    }

    /**
     * @param string $style
     * @param int    $size
     *
     * @return \TCPDF
     */
    public function setStyleSize($style = '', $size = 8)
    {
        $this->engine->SetFont(ConstantsEnum::PDF_DEFAULT_FONT, $style, $size);

        return $this->engine;
    }
}

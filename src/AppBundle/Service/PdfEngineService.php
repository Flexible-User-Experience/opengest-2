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
     * @param string $author
     * @param string $subject
     */
    public function __construct($author, $subject)
    {
        $this->engine = new \TCPDF();
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

        // set default header data
        $this->engine->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $this->engine->setFooterData(array(0, 64, 0), array(0, 64, 128));

        // set header and footer fonts
        $this->engine->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $this->engine->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $this->engine->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $this->engine->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->engine->SetHeaderMargin(PDF_MARGIN_HEADER);
        $this->engine->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $this->engine->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $this->engine->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set default font subsetting mode
        $this->engine->setFontSubsetting(true);

        // set font
        $this->engine->SetFont('dejavusans', '', 14, '', true);

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
}

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
     * @param string $orientation
     * @param string $units
     * @param string $title
     *
     * @return \TCPDF
     */
    public function initPageEngine($orientation = ConstantsEnum::PDF_PORTRAIT_PAGE_ORIENTATION, $units = ConstantsEnum::PDF_PAGE_UNITS, $title = '')
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

        return $this->engine;
    }
}

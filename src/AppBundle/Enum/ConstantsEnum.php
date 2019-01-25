<?php

namespace AppBundle\Enum;

/**
 * ConstantsEnum class.
 *
 * @category Enum
 */
class ConstantsEnum
{
    /**
     * Business.
     */
    const IVA = 21;
    const IRPF = 0;

    /**
     * Frontend.
     */
    const FRONTEND_ITEMS_PER_PAGE_LIMIT = 10;

    /**
     * PDF.
     */
    const PDF_PORTRAIT_PAGE_ORIENTATION = 'P';
    const PDF_LANDSCAPE_PAGE_ORIENTATION = 'L';
    const PDF_PAGE_UNITS = 'mm';
}

<?php

namespace AppBundle\Manager;

/**
 * Class YearChoicesManager.
 *
 * @category Manager
 **/
class YearChoicesManager
{
    const INITIAL_YEAR = 1980;

    /**
     * @return array
     */
    public function getYearRange()
    {
        $currentYear = new \DateTime();
        $years = array();
        for ($currentYear = intval($currentYear->format('Y')) + 1; $currentYear >= self::INITIAL_YEAR; --$currentYear) {
            $years[] = $currentYear;
        }

        return $years;
    }

    /**
     * @return int
     */
    public function getCurrentYear()
    {
        $currentYear = new \DateTime();
        $currentYear = intval($currentYear->format('Y'));

        return $currentYear;
    }
}

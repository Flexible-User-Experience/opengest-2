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
     * Methods.
     */

    /**
     * @return array
     *
     * @throws \Exception
     */
    public function getYearRange()
    {
        $currentYear = new \DateTime();
        $years = array();
        for ($currentYear = intval($currentYear->format('Y')) + 1; $currentYear >= self::INITIAL_YEAR; --$currentYear) {
            $years[$currentYear] = $currentYear;
        }

        return $years;
    }

    /**
     * @return int
     *
     * @throws \Exception
     */
    public function getCurrentYear()
    {
        $currentYear = new \DateTime();
        $currentYear = intval($currentYear->format('Y'));

        return $currentYear;
    }

    /**
     * @return string
     *
     * @throws \Exception
     */
    public function getTodayString()
    {
        $today = new \DateTime();
        $today = $today->format('d/m/Y');

        return $today;
    }
}

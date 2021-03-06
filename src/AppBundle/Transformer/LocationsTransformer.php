<?php

namespace AppBundle\Transformer;

use AppBundle\Enum\ConstantsEnum;

/**
 * Class LocationsTransformer.
 *
 * @category Transformer
 *
 * @author   David Romaní <david@flux.cat>
 */
class LocationsTransformer
{
    /**
     * @param string $country
     *
     * @return string
     */
    public function countryToCode($country)
    {
        if ('ALEMANIA' == $country || 'GERMANY' == $country) {
            $result = 'DE';
        } elseif ('BELGICA' == $country || 'BELGIUM' == $country) {
            $result = 'BE';
        } elseif ('REPUBLICA CHECA' == $country || 'CZECH REPUBLIC' == $country) {
            $result = 'CZ';
        } elseif ('FRANCIA' == $country || 'FRANCE' == $country) {
            $result = 'FR';
        } elseif ('LITUANIA' == $country || 'LITHUANIA' == $country) {
            $result = 'LT';
        } elseif ('MARRUECOS' == $country || 'MOROCCO' == $country) {
            $result = 'MA';
        } elseif ('HOLANDA' == $country || 'NETHERLANDS' == $country) {
            $result = 'NL';
        } elseif ('POLONIA' == $country || 'POLAND' == $country) {
            $result = 'PL';
        } elseif ('PORTUGAL' == $country) {
            $result = 'PT';
        } elseif ('REINO UNIDO' == $country || 'GREAT BRITAIN' == $country || 'UNITED KINGDOM' == $country) {
            $result = 'GB';
        } else {
            $result = ConstantsEnum::DEFAULT_COUNTRY_CODE_SPAIN;
        }

        return $result;
    }

    /**
     * @param string $code
     *
     * @return string
     */
    public function codeToCountry($code)
    {
        $code = strtoupper($code);
        if ('DE' == $code) {
            $result = 'ALEMANIA';
        } elseif ('BE' == $code) {
            $result = 'BELGICA';
        } elseif ('REPUBLICA CHECA' == $code) {
            $result = 'REPUBLICA CHECA';
        } elseif ('FR' == $code) {
            $result = 'FRANCIA';
        } elseif ('LT' == $code) {
            $result = 'LITUANIA';
        } elseif ('MA' == $code) {
            $result = 'MARRUECOS';
        } elseif ('NL' == $code) {
            $result = 'HOLANDA';
        } elseif ('PL' == $code) {
            $result = 'POLONIA';
        } elseif ('PT' == $code) {
            $result = 'PORTUGAL';
        } elseif ('GB' == $code) {
            $result = 'REINO UNIDO';
        } else {
            $result = ConstantsEnum::DEFAULT_COUNTRY_SPAIN;
        }

        return $result;
    }

    /**
     * @param string $countryName
     *
     * @return string
     */
    public function countryNameCleaner($countryName)
    {
        return $this->commonNameCleaner($countryName);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function provinceNameCleaner($name)
    {
        if (strlen($name) > 0) {
            // remove first blank character from string
            if (' ' == substr($name, 0, 1)) {
                $name = substr($name, 1);
            }
            if ('ALMERÍA' == $name || 'ALMERíA' == $name) {
                $name = 'ALMERIA';
            } elseif ('CASTELLO' == $name || 'CASTELLÓ' == $name || 'CASTELLó' == $name || 'CASTELLÓN' == $name || 'CASTELLóN' == $name) {
                $name = 'CASTELLON';
            } elseif ('CORUÑA, LA' == $name || 'CORUñA, LA' == $name || 'A CORUÑA' == $name || 'A CORUñA' == $name) {
                $name = 'LA CORUÑA';
            } elseif ('LLEIDA' == $name || 'LéRIDA' == $name || 'LÉRIDA' == $name) {
                $name = 'LERIDA';
            } elseif ('MÚRCIA' == $name || 'MúRCIA' == $name) {
                $name = 'MURCIA';
            } elseif ('GIRONA' == $name) {
                $name = 'GERONA';
            }
        } else {
            $name = '---';
        }

        return strtoupper($name);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function cityNameCleaner($name)
    {
        return $this->commonNameCleaner($name);
    }

    /**
     * @param string $postalCode
     *
     * @return string
     */
    public function postalCodeCleaner($postalCode)
    {
        return $this->commonNameCleaner($postalCode);
    }

    /**
     * @param string $taxIdentificationNumber
     *
     * @return string
     */
    public function taxIdentificationNumberCleaner($taxIdentificationNumber)
    {
        return $this->commonNameCleaner($taxIdentificationNumber);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function nameCleaner($name)
    {
        return $this->commonNameCleaner($name);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    private function commonNameCleaner($name)
    {
        if (strlen($name) > 0) {
            // remove first blank character from string
            if (' ' == substr($name, 0, 1)) {
                $name = substr($name, 1);
            }
        } else {
            // set blank mark
            $name = '---';
        }

        return strtoupper($name);
    }
}

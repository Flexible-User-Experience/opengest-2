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
        $country = strtoupper($country);
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
     * @param string $name
     *
     * @return string
     */
    public function provinceNameCleaner($name)
    {
        // remove first blank character from string
        if (' ' == substr($name, 0, 1)) {
            $name = substr($name, 1);
        }
        if ('ALMERÍA' == $name) {
            $name = 'ALMERIA';
        } elseif ('CASTELLO' == $name || 'CASTELLÓN' == $name) {
            $name = 'CASTELLON';
        } elseif ('CORUÑA, LA' == $name || 'LA CORUÑA' == $name) {
            $name = 'CASTELLON';
        } elseif ('LLEIDA' == $name || 'LÉRIDA' == $name) {
            $name = 'LERIDA';
        }

        return $name;
    }
}

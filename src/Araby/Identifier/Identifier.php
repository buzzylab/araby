<?php

namespace ArabyPHP\Identifier;

class Identifier
{
    /**
     * Identify Arabic text in a given UTF-8 multi language string.
     *
     * @param string $str UTF-8 multi language string
     *
     * @return array Offset of the beginning and end of each Arabic segment in
     *               sequence in the given UTF-8 multi language string
     *
     */
    public function identify($str)
    {
        $minAr = 55436;
        $maxAr = 55698;
        $probAr = false;
        $arFlag = false;
        $arRef = [];
        $max = strlen($str);

        $i = -1;
        while (++$i < $max) {
            $cDec = ord($str[$i]);

            // ignore ! " # $ % & ' ( ) * + , - . / 0 1 2 3 4 5 6 7 8 9 :
            // If it come in the Arabic context
            if ($cDec >= 33 && $cDec <= 58) {
                continue;
            }

            if (!$probAr && ($cDec == 216 || $cDec == 217)) {
                $probAr = true;
                continue;
            }

            if ($i > 0) {
                $pDec = ord($str[$i - 1]);
            } else {
                $pDec = null;
            }

            if ($probAr) {
                $utfDecCode = ($pDec << 8) + $cDec;

                if ($utfDecCode >= $minAr && $utfDecCode <= $maxAr) {
                    if (!$arFlag) {
                        $arFlag = true;
                        $arRef[] = $i - 1;
                    }
                } else {
                    if ($arFlag) {
                        $arFlag = false;
                        $arRef[] = $i - 1;
                    }
                }

                $probAr = false;
                continue;
            }

            if ($arFlag && !preg_match("/^\s$/", $str[$i])) {
                $arFlag = false;
                $arRef[] = $i;
            }
        }

        return $arRef;
    }

    /**
     * Find out if given string is Arabic text or not.
     *
     * @param string $str String
     *
     * @return bool True if given string is UTF-8 Arabic, else will return False
     *
     */
    public function isArabic($str)
    {
        $isArabic = false;
        $arr = $this->identify($str);

        if (count($arr) == 1 && $arr[0] == 0) {
            $isArabic = true;
        }

        return $isArabic;
    }
}

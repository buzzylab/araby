<?php

namespace Araby\KeySwap;

class KeySwap
{
    /**
     * @var array
     */
    private $_transliteration = [];

    /**
     * @var array
     */
    private $_arLogodd;

    /**
     * @var array
     */
    private $_enLogodd;

    /**
     * @var array
     */
    private $_arKeyboard;

    /**
     * @var array
     */
    private $_enKeyboard;

    /**
     * @var array
     */
    private $_frKeyboard;

    /**
     * Loads initialize values.
     *
     * @ignore
     */
    public function __construct()
    {
        $xml = simplexml_load_file(__DIR__.'/data/arabizi.xml');

        foreach ($xml->transliteration->item as $item) {
            $index = $item['id'];
            $this->_transliteration["$index"] = (string) $item;
        }

        $xml = simplexml_load_file(__DIR__.'/data/ArKeySwap.xml');

        foreach ($xml->arabic->key as $key) {
            $index = (int) $key['id'];
            $this->_arKeyboard[$index] = (string) $key;
        }

        foreach ($xml->english->key as $key) {
            $index = (int) $key['id'];
            $this->_enKeyboard[$index] = (string) $key;
        }

        foreach ($xml->french->key as $key) {
            $index = (int) $key['id'];
            $this->_frKeyboard[$index] = (string) $key;
        }

        $this->_arLogodd = file(__DIR__.'/data/ar-logodd.php');
        $this->_enLogodd = file(__DIR__.'/data/en-logodd.php');
    }

    /**
     * Make conversion to swap that odd Arabic text by original English sentence
     * you meant when you type on your keyboard (if keyboard language was
     * incorrect).
     *
     * @param string $text Odd Arabic string
     *
     * @return string Normal English string
     *
     */
    public function swapAe($text)
    {
        $output = $this->_swapCore($text, 'ar', 'en');

        return $output;
    }

    /**
     * Make conversion to swap that odd English text by original Arabic sentence
     * you meant when you type on your keyboard (if keyboard language was
     * incorrect).
     *
     * @param string $text Odd English string
     *
     * @return string Normal Arabic string
     *
     */
    public function swapEa($text)
    {
        $output = $this->_swapCore($text, 'en', 'ar');

        return $output;
    }

    /**
     * Make conversion to swap that odd Arabic text by original French sentence
     * you meant when you type on your keyboard (if keyboard language was
     * incorrect).
     *
     * @param string $text Odd Arabic string
     *
     * @return string Normal French string
     *
     */
    public function swapAf($text)
    {
        $output = $this->_swapCore($text, 'ar', 'fr');

        return $output;
    }

    /**
     * Make conversion to swap that odd French text by original Arabic sentence
     * you meant when you type on your keyboard (if keyboard language was
     * incorrect).
     *
     * @param string $text Odd French string
     *
     * @return string Normal Arabic string
     *
     */
    public function swapFa($text)
    {
        $output = $this->_swapCore($text, 'fr', 'ar');

        return $output;
    }

    /**
     * Make conversion between different keyboard maps to swap odd text in
     * one language by original meaningful text in another language that
     * you meant when you type on your keyboard (if keyboard language was
     * incorrect).
     *
     * @param string $text Odd string
     * @param string $in   Input language [ar|en|fr]
     * @param string $out  Output language [ar|en|fr]
     *
     * @return string Normal string
     *
     */
    private function _swapCore($text, $in, $out)
    {
        $output = '';
        $text = stripslashes($text);
        $max = mb_strlen($text);

        switch ($in) {
        case 'ar':
            $inputMap = $this->_arKeyboard;
            break;
        case 'en':
            $inputMap = $this->_enKeyboard;
            break;
        case 'fr':
            $inputMap = $this->_frKeyboard;
            break;
        }

        switch ($out) {
        case 'ar':
            $outputMap = $this->_arKeyboard;
            break;
        case 'en':
            $outputMap = $this->_enKeyboard;
            break;
        case 'fr':
            $outputMap = $this->_frKeyboard;
            break;
        }

        for ($i = 0; $i < $max; $i++) {
            $chr = mb_substr($text, $i, 1);
            $key = array_search($chr, $inputMap);

            if ($key === false) {
                $output .= $chr;
            } else {
                $output .= $outputMap[$key];
            }
        }

        return $output;
    }

    /**
     * Calculate the log odd probability that inserted string from keyboard
     * is in English language.
     *
     * @param string $str Inserted string from the keyboard
     *
     * @return float Calculated score for input string as English language
     *
     */
    protected function checkEn($str)
    {
        $lines = $this->_enLogodd;
        $logodd = [];

        $line = array_shift($lines);
        $line = rtrim($line);
        $second = preg_split("/\t/", $line);
        $temp = array_shift($second);

        foreach ($lines as $line) {
            $line = rtrim($line);
            $values = preg_split("/\t/", $line);
            $first = array_shift($values);

            for ($i = 0; $i < 28; $i++) {
                $logodd["$first"]["{$second[$i]}"] = $values[$i];
            }
        }

        $str = mb_strtolower($str);
        $max = mb_strlen($str, 'UTF-8');
        $rank = 0;

        for ($i = 1; $i < $max; $i++) {
            $first = mb_substr($str, $i - 1, 1, 'UTF-8');
            $second = mb_substr($str, $i, 1, 'UTF-8');

            if (isset($logodd["$first"]["$second"])) {
                $rank += $logodd["$first"]["$second"];
            } else {
                $rank -= 10;
            }
        }

        return $rank;
    }

    /**
     * Calculate the log odd probability that inserted string from keyboard
     * is in Arabic language.
     *
     * @param string $str Inserted string from the keyboard
     *
     * @return float Calculated score for input string as Arabic language
     *
     */
    protected function checkAr($str)
    {
        $lines = $this->_arLogodd;
        $logodd = [];

        $line = array_shift($lines);
        $line = rtrim($line);
        $second = preg_split("/\t/", $line);
        $temp = array_shift($second);

        foreach ($lines as $line) {
            $line = rtrim($line);
            $values = preg_split("/\t/", $line);
            $first = array_shift($values);

            for ($i = 0; $i < 37; $i++) {
                $logodd["$first"]["{$second[$i]}"] = $values[$i];
            }
        }

        $max = mb_strlen($str, 'UTF-8');
        $rank = 0;

        for ($i = 1; $i < $max; $i++) {
            $first = mb_substr($str, $i - 1, 1, 'UTF-8');
            $second = mb_substr($str, $i, 1, 'UTF-8');

            if (isset($logodd["$first"]["$second"])) {
                $rank += $logodd["$first"]["$second"];
            } else {
                $rank -= 10;
            }
        }

        return $rank;
    }

    /**
     * This method will automatically detect the language of content supplied
     * in the input string. It will return the suggestion of correct inserted text.
     * The accuracy of the automatic language detection increases with the amount
     * of text entered.
     *
     * @param string $str Inserted string from the keyboard
     *
     * @return string Fixed string language and letter case to the better guess
     *
     */
    public function fixKeyboardLang($str)
    {
        preg_match_all("/([\x{0600}-\x{06FF}])/u", $str, $matches);

        $arNum = count($matches[0]);
        $nonArNum = mb_strlen(str_replace(' ', '', $str), 'UTF-8') - $arNum;

        $capital = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $small = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        if ($arNum > $nonArNum) {
            $arStr = $str;
            $enStr = $this->swapAe($str);
            $isAr = true;
        } else {
            $arStr = $this->swapEa($str);
            $enStr = $str;

            $strCaps = strtr($str, $capital, $small);
            $arStrCaps = $this->swapEa($strCaps);

            $isAr = false;
        }

        $enRank = $this->checkEn($enStr);
        $arRank = $this->checkAr($arStr);

        if ($arNum > $nonArNum) {
            $arCapsRank = $arRank;
        } else {
            $arCapsRank = $this->checkAr($arStrCaps);
        }

        if ($enRank > $arRank && $enRank > $arCapsRank) {
            if ($isAr) {
                $fix = $enStr;
            } else {
                preg_match_all('/([A-Z])/u', $enStr, $matches);
                $capsNum = count($matches[0]);

                preg_match_all('/([a-z])/u', $enStr, $matches);
                $nonCapsNum = count($matches[0]);

                if ($capsNum > $nonCapsNum && $nonCapsNum > 0) {
                    $enCapsStr = strtr($enStr, $capital, $small);
                    $fix = $enCapsStr;
                } else {
                    $fix = '';
                }
            }
        } else {
            if ($arCapsRank > $arRank) {
                $arStr = $arStrCaps;
                $arRank = $arCapsRank;
            }

            if (!$isAr) {
                $fix = $arStr;
            } else {
                $fix = '';
            }
        }

        return $fix;
    }
}

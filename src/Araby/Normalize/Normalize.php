<?php

namespace Araby\Normalize;

class Normalize
{
    /**
     * @var array
     */
    private $_unshapeMap = [];

    /**
     * @var array
     */
    private $_unshapeKeys = [];

    /**
     * @var array
     */
    private $_unshapeValues = [];

    /**
     * @var array
     */
    private $_chars = [];

    /**
     * @var array
     */
    private $_charGroups = [];

    /**
     * @var array
     */
    private $_charArNames = [];

    /**
     * Load the Unicode constants that will be used ibn substitutions
     * and normalisations.
     *
     * @ignore
     */
    public function __construct()
    {
        include __DIR__.'/data/ArUnicode.constants.php';

        $this->_unshapeMap = $ligature_map;
        $this->_unshapeKeys = array_keys($this->_unshapeMap);
        $this->_unshapeValues = array_values($this->_unshapeMap);
        $this->_chars = $char_names;
        $this->_charGroups = $char_groups;
        $this->_charArNames = $char_ar_names;
    }

    /**
     * Strip all tatweel characters from an Arabic text.
     *
     * @param string $text The text to be stripped.
     *
     * @return string the stripped text.
     */
    public function stripTatweel($text)
    {
        return str_replace($this->_chars['TATWEEL'], '', $text);
    }

    /**
     * Strip all tashkeel characters from an Arabic text.
     *
     * @param string $text The text to be stripped.
     *
     * @return string the stripped text.
     *
     */
    public function stripTashkeel($text)
    {
        $tashkeel = [
             $this->_chars['FATHATAN'],
             $this->_chars['DAMMATAN'],
             $this->_chars['KASRATAN'],
             $this->_chars['FATHA'],
             $this->_chars['DAMMA'],
             $this->_chars['KASRA'],
             $this->_chars['SUKUN'],
             $this->_chars['SHADDA'],
        ];

        return str_replace($tashkeel, '', $text);
    }

    /**
     * Normalise all Hamza characters to their corresponding aleph
     * character in an Arabic text.
     *
     * @param string $text The text to be normalised.
     *
     * @return string the normalised text.
     */
    public function normaliseHamza($text)
    {
        $replace = [
             $this->_chars['WAW_HAMZA'] = $this->_chars['WAW'],
             $this->_chars['YEH_HAMZA'] = $this->_chars['YEH'],
        ];

        $alephs = [
             $this->_chars['ALEF_MADDA'],
             $this->_chars['ALEF_HAMZA_ABOVE'],
             $this->_chars['ALEF_HAMZA_BELOW'],
             $this->_chars['HAMZA_ABOVE'],
             $this->_chars['HAMZA_BELOW'],
        ];

        $text = str_replace(array_keys($replace), array_values($replace), $text);
        $text = str_replace($alephs, $this->_chars['ALEF'], $text);

        return $text;
    }

    /**
     * Unicode uses some special characters where the lamaleph and any
     * hamza above them are combined into one code point. Some input
     * system use them. This function expands these characters.
     *
     * @param string $text The text to be normalised.
     *
     * @return string the normalised text.
     */
    public function normaliseLamaleph($text)
    {
        $text = str_replace($this->_chars['LAM_ALEPH'], $simple_LAM_ALEPH, $text);
        $text = str_replace($this->_chars['LAM_ALEPH_HAMZA_ABOVE'], $simple_LAM_ALEPH_HAMZA_ABOVE, $text);
        $text = str_replace($this->_chars['LAM_ALEPH_HAMZA_BELOW'], $simple_LAM_ALEPH_HAMZA_BELOW, $text);
        $text = str_replace($this->_chars['LAM_ALEPH_MADDA_ABOVE'], $simple_LAM_ALEPH_MADDA_ABOVE, $text);

        return $text;
    }

    /**
     * Return unicode char by its code point.
     *
     * @param char $u code point
     *
     * @return string the result character.
     */
    public function unichr($u)
    {
        return mb_convert_encoding('&#'.intval($u).';', 'UTF-8', 'HTML-ENTITIES');
    }

    /**
     * Takes a string, it applies the various filters in this class
     * to return a unicode normalised string suitable for activities
     * such as searching, indexing, etc.
     *
     * @param string $text the text to be normalised.
     *
     * @return string the result normalised string.
     */
    public function normalise($text)
    {
        $text = $this->stripTashkeel($text);
        $text = $this->stripTatweel($text);
        $text = $this->normaliseHamza($text);
        $text = $this->normaliseLamaleph($text);

        return $text;
    }

    /**
     * Takes Arabic text in its joined form, it untangles the characters
     * and  unshapes them.
     *
     * This can be used to process text that was processed through OCR
     * or by extracting text from a PDF document.
     *
     * Note that the result text may need further processing. In most
     * cases, you will want to use the utf8Strrev function from
     * this class to reverse the string.
     *
     * Most of the work of setting up the characters for this function
     * is done through the ArUnicode.constants.php constants and
     * the constructor loading.
     *
     * @param string $text the text to be unshaped.
     *
     * @return string the result normalised string.
     */
    public function unshape($text)
    {
        return str_replace($this->_unshapeKeys, $this->_unshapeValues, $text);
    }

    /**
     * Take a UTF8 string and reverse it.
     *
     * @param string $str             the string to be reversed.
     * @param bool   $reverse_numbers whether to reverse numbers.
     *
     * @return string The reversed string.
     */
    public function utf8Strrev($str, $reverse_numbers = false)
    {
        preg_match_all('/./us', $str, $ar);
        if ($reverse_numbers) {
            return implode('', array_reverse($ar[0]));
        } else {
            $temp = [];
            foreach ($ar[0] as $value) {
                if (is_numeric($value) && !empty($temp[0]) && is_numeric($temp[0])) {
                    foreach ($temp as $key => $value2) {
                        if (is_numeric($value2)) {
                            $pos = ($key + 1);
                        } else {
                            break;
                        }
                    }
                    $temp2 = array_splice($temp, $pos);
                    $temp = array_merge($temp, [$value], $temp2);
                } else {
                    array_unshift($temp, $value);
                }
            }

            return implode('', $temp);
        }
    }

    /**
     * Checks for Arabic Tashkeel marks (i.e. FATHA, DAMMA, KASRA, SUKUN,
     * SHADDA, FATHATAN, DAMMATAN, KASRATAN).
     *
     * @param string $archar Arabic unicode char
     *
     * @return bool True if it is Arabic Tashkeel mark
     */
    public function isTashkeel($archar)
    {
        $key = array_search($archar, $this->_chars);

        if (in_array($key, $this->_charGroups['TASHKEEL'])) {
            $value = true;
        } else {
            $value = false;
        }

        return $value;
    }

    /**
     * Checks for Arabic Harakat marks (i.e. FATHA, DAMMA, KASRA, SUKUN, TANWIN).
     *
     * @param string $archar Arabic unicode char
     *
     * @return bool True if it is Arabic Harakat mark
     */
    public function isHaraka($archar)
    {
        $key = array_search($archar, $this->_chars);

        if (in_array($key, $this->_charGroups['HARAKAT'])) {
            $value = true;
        } else {
            $value = false;
        }

        return $value;
    }

    /**
     * Checks for Arabic short Harakat marks (i.e. FATHA, DAMMA, KASRA, SUKUN).
     *
     * @param string $archar Arabic unicode char
     *
     * @return bool True if it is Arabic short Harakat mark
     */
    public function isShortharaka($archar)
    {
        $key = array_search($archar, $this->_chars);

        if (in_array($key, $this->_charGroups['SHORTHARAKAT'])) {
            $value = true;
        } else {
            $value = false;
        }

        return $value;
    }

    /**
     * Checks for Arabic Tanwin marks (i.e. FATHATAN, DAMMATAN, KASRATAN).
     *
     * @param string $archar Arabic unicode char
     *
     * @return bool True if it is Arabic Tanwin mark
     */
    public function isTanwin($archar)
    {
        $key = array_search($archar, $this->_chars);

        if (in_array($key, $this->_charGroups['TANWIN'])) {
            $value = true;
        } else {
            $value = false;
        }

        return $value;
    }

    /**
     * Checks for Arabic Ligatures like LamAlef (i.e. LAM ALEF, LAM ALEF HAMZA
     * ABOVE, LAM ALEF HAMZA BELOW, LAM ALEF MADDA ABOVE).
     *
     * @param string $archar Arabic unicode char
     *
     * @return bool True if it is Arabic Ligatures like LamAlef
     */
    public function isLigature($archar)
    {
        $key = array_search($archar, $this->_chars);

        if (in_array($key, $this->_charGroups['LIGUATURES'])) {
            $value = true;
        } else {
            $value = false;
        }

        return $value;
    }

    /**
     * Checks for Arabic Hamza forms (i.e. HAMZA, WAW HAMZA, YEH HAMZA, HAMZA ABOVE,
     * HAMZA BELOW, ALEF HAMZA BELOW, ALEF HAMZA ABOVE).
     *
     * @param string $archar Arabic unicode char
     *
     * @return bool True if it is Arabic Hamza form
     */
    public function isHamza($archar)
    {
        $key = array_search($archar, $this->_chars);

        if (in_array($key, $this->_charGroups['HAMZAT'])) {
            $value = true;
        } else {
            $value = false;
        }

        return $value;
    }

    /**
     * Checks for Arabic Alef forms (i.e. ALEF, ALEF MADDA, ALEF HAMZA ABOVE,
     * ALEF HAMZA BELOW,ALEF WASLA, ALEF MAKSURA).
     *
     * @param string $archar Arabic unicode char
     *
     * @return bool True if it is Arabic Alef form
     *
     */
    public function isAlef($archar)
    {
        $key = array_search($archar, $this->_chars);

        if (in_array($key, $this->_charGroups['ALEFAT'])) {
            $value = true;
        } else {
            $value = false;
        }

        return $value;
    }

    /**
     * Checks for Arabic Weak letters (i.e. ALEF, WAW, YEH, ALEF_MAKSURA).
     *
     * @param string $archar Arabic unicode char
     *
     * @return bool True if it is Arabic Weak letter
     *
     */
    public function isWeak($archar)
    {
        $key = array_search($archar, $this->_chars);

        if (in_array($key, $this->_charGroups['WEAK'])) {
            $value = true;
        } else {
            $value = false;
        }

        return $value;
    }

    /**
     * Checks for Arabic Yeh forms (i.e. YEH, YEH HAMZA, SMALL YEH, ALEF MAKSURA).
     *
     * @param string $archar Arabic unicode char
     *
     * @return bool True if it is Arabic Yeh form
     *
     */
    public function isYehlike($archar)
    {
        $key = array_search($archar, $this->_chars);

        if (in_array($key, $this->_charGroups['YEHLIKE'])) {
            $value = true;
        } else {
            $value = false;
        }

        return $value;
    }

    /**
     * Checks for Arabic Waw like forms (i.e. WAW, WAW HAMZA, SMALL WAW).
     *
     * @param string $archar Arabic unicode char
     *
     * @return bool True if it is Arabic Waw like form
     *
     */
    public function isWawlike($archar)
    {
        $key = array_search($archar, $this->_chars);

        if (in_array($key, $this->_charGroups['WAWLIKE'])) {
            $value = true;
        } else {
            $value = false;
        }

        return $value;
    }

    /**
     * Checks for Arabic Teh forms (i.e. TEH, TEH MARBUTA).
     *
     * @param string $archar Arabic unicode char
     *
     * @return bool True if it is Arabic Teh form
     *
     */
    public function isTehlike($archar)
    {
        $key = array_search($archar, $this->_chars);

        if (in_array($key, $this->_charGroups['TEHLIKE'])) {
            $value = true;
        } else {
            $value = false;
        }

        return $value;
    }

    /**
     * Checks for Arabic Small letters (i.e. SMALL ALEF, SMALL WAW, SMALL YEH).
     *
     * @param string $archar Arabic unicode char
     *
     * @return bool True if it is Arabic Small letter
     *
     */
    public function isSmall($archar)
    {
        $key = array_search($archar, $this->_chars);

        if (in_array($key, $this->_charGroups['SMALL'])) {
            $value = true;
        } else {
            $value = false;
        }

        return $value;
    }

    /**
     * Checks for Arabic Moon letters.
     *
     * @param string $archar Arabic unicode char
     *
     * @return bool True if it is Arabic Moon letter
     *
     */
    public function isMoon($archar)
    {
        $key = array_search($archar, $this->_chars);

        if (in_array($key, $this->_charGroups['MOON'])) {
            $value = true;
        } else {
            $value = false;
        }

        return $value;
    }

    /**
     * Checks for Arabic Sun letters.
     *
     * @param string $archar Arabic unicode char
     *
     * @return bool True if it is Arabic Sun letter
     *
     */
    public function isSun($archar)
    {
        $key = array_search($archar, $this->_chars);

        if (in_array($key, $this->_charGroups['SUN'])) {
            $value = true;
        } else {
            $value = false;
        }

        return $value;
    }

    /**
     * Return Arabic letter name in arabic.
     *
     * @param string $archar Arabic unicode char
     *
     * @return string Arabic letter name in arabic
     *
     */
    public function charName($archar)
    {
        $key = array_search($archar, $this->_chars);

        $name = $this->_charArNames["$key"];

        return $name;
    }
}

<?php


namespace Buzzylab\Aip\Models;

class Numbers
{
    /**
     * @var array
     */
    private $_individual = [];

    /**
     * @var array
     */
    private $_complications = [];

    /**
     * @var array
     */
    private $_arabicIndic = [];

    /**
     * @var array
     */
    private $_ordering = [];

    /**
     * @var array
     */
    private $_currency = [];

    /**
     * @var array
     */
    private $_spell = [];

    /**
     * @var int
     */
    private $_feminine = 1;

    /**
     * @var int
     */
    private $_format = 1;

    /**
     * @var int
     */
    private $_order = 1;

    /**
     * Loads initialize values.
     *
     * @ignore
     */
    public function __construct()
    {
        $xml = simplexml_load_file(__DIR__.'/data/ArNumbers.xml');

        foreach ($xml->xpath("//individual/number[@gender='male']") as $num) {
            if (isset($num['grammar'])) {
                $grammar = $num['grammar'];

                $this->_individual["{$num['value']}"][1]["$grammar"] = (string) $num;
            } else {
                $this->_individual["{$num['value']}"][1] = (string) $num;
            }
        }

        foreach ($xml->xpath("//individual/number[@gender='female']") as $num) {
            if (isset($num['grammar'])) {
                $grammar = $num['grammar'];

                $this->_individual["{$num['value']}"][2]["$grammar"] = (string) $num;
            } else {
                $this->_individual["{$num['value']}"][2] = (string) $num;
            }
        }

        foreach ($xml->xpath('//individual/number[@value>19]') as $num) {
            if (isset($num['grammar'])) {
                $grammar = $num['grammar'];

                $this->_individual["{$num['value']}"]["$grammar"] = (string) $num;
            } else {
                $this->_individual["{$num['value']}"] = (string) $num;
            }
        }

        foreach ($xml->complications->number as $num) {
            $scale = $num['scale'];
            $format = $num['format'];

            $this->_complications["$scale"]["$format"] = (string) $num;
        }

        foreach ($xml->arabicIndic->number as $html) {
            $value = $html['value'];

            $this->_arabicIndic["$value"] = $html;
        }

        foreach ($xml->xpath("//order/number[@gender='male']") as $num) {
            $this->_ordering["{$num['value']}"][1] = (string) $num;
        }

        foreach ($xml->xpath("//order/number[@gender='female']") as $num) {
            $this->_ordering["{$num['value']}"][2] = (string) $num;
        }

        $expression = '//individual/number[@value<11 or @value>19]';
        foreach ($xml->xpath($expression) as $num) {
            $str = str_replace(['أ', 'إ', 'آ'], 'ا', (string) $num);
            $this->_spell[$str] = (int) $num['value'];
        }

        $xml = simplexml_load_file(__DIR__.'/data/arab_countries.xml');

        foreach ($xml->xpath('//currency') as $info) {
            $money_ar = $info->money->arabic;
            $money_en = $info->money->english;

            $this->_currency["{$info->iso}"]['ar']['basic'] = $money_ar->basic;
            $this->_currency["{$info->iso}"]['ar']['fraction'] = $money_ar->fraction;
            $this->_currency["{$info->iso}"]['en']['basic'] = $money_en->basic;
            $this->_currency["{$info->iso}"]['en']['fraction'] = $money_en->fraction;

            $this->_currency["{$info->iso}"]['decimals'] = $info->money->decimals;
        }
    }

    /**
     * Set feminine flag of the counted object.
     *
     * @param int $value Counted object feminine
     *                   (1 for masculine & 2 for feminine)
     *
     * @return object $this to build a fluent interface
     *
     */
    public function setFeminine($value)
    {
        if ($value == 1 || $value == 2) {
            $this->_feminine = $value;
        }

        return $this;
    }

    /**
     * Set the grammar position flag of the counted object.
     *
     * @param int $value Grammar position of counted object
     *                   (1 if Marfoua & 2 if Mansoub or Majrour)
     *
     * @return object $this to build a fluent interface
     *
     */
    public function setFormat($value)
    {
        if ($value == 1 || $value == 2) {
            $this->_format = $value;
        }

        return $this;
    }

    /**
     * Set the ordering flag, is it normal number or ordering number.
     *
     * @param int $value Is it an ordering number? default is 1
     *                   (use 1 if no and 2 if yes)
     *
     * @return object $this to build a fluent interface
     *
     */
    public function setOrder($value)
    {
        if ($value == 1 || $value == 2) {
            $this->_order = $value;
        }

        return $this;
    }

    /**
     * Get the feminine flag of counted object.
     *
     * @return int return current setting of counted object feminine flag
     *
     */
    public function getFeminine()
    {
        return $this->_feminine;
    }

    /**
     * Get the grammer position flag of counted object.
     *
     * @return int return current setting of counted object grammer
     *             position flag
     *
     */
    public function getFormat()
    {
        return $this->_format;
    }

    /**
     * Get the ordering flag value.
     *
     * @return int return current setting of ordering flag value
     *
     */
    public function getOrder()
    {
        return $this->_format;
    }

    /**
     * Spell integer number in Arabic idiom.
     *
     * @param int $number The number you want to spell in Arabic idiom
     *
     * @return string The Arabic idiom that spells inserted number
     *
     */
    public function int2str($number)
    {
        if ($number == 1 && $this->_order == 2) {
            if ($this->_feminine == 1) {
                $string = 'الأول';
            } else {
                $string = 'الأولى';
            }
        } else {
            if ($number < 0) {
                $string = 'سالب ';
                $number = (string) -1 * $number;
            } else {
                $string = '';
            }

            $temp = explode('.', $number);

            $string .= $this->subInt2str($temp[0]);

            if (!empty($temp[1])) {
                $dec = $this->subInt2str($temp[1]);
                $string .= ' فاصلة '.$dec;
            }
        }

        return $string;
    }

    /**
     * Spell number in Arabic idiom as money.
     *
     * @param int    $number The number you want to spell in Arabic idiom as money
     * @param string $iso    The three-letter Arabic country code defined in
     *                       ISO 3166 standard
     * @param string $lang   The two-letter language code in ISO 639-1 standard
     *                       [ar|en]
     *
     * @return string The Arabic idiom that spells inserted number as money
     *
     */
    public function money2str($number, $iso = 'SYP', $lang = 'ar')
    {
        $iso = strtoupper($iso);
        $lang = strtolower($lang);

        $number = sprintf("%01.{$this->_currency[$iso]['decimals']}f", $number);
        $temp = explode('.', $number);
        $string = '';

        if ($temp[0] != 0) {
            $string .= $this->subInt2str($temp[0]);
            $string .= ' '.$this->_currency[$iso][$lang]['basic'];
        }

        if (!empty($temp[1]) && $temp[1] != 0) {
            if ($string != '') {
                if ($lang == 'ar') {
                    $string .= ' و ';
                } else {
                    $string .= ' and ';
                }
            }

            $string .= $this->subInt2str((int) $temp[1]);
            $string .= ' '.$this->_currency[$iso][$lang]['fraction'];
        }

        return $string;
    }

    /**
     * Convert Arabic idiom number string into Integer.
     *
     * @param string $str The Arabic idiom that spells input number
     *
     * @return int The number you spell it in the Arabic idiom
     *
     */
    public function str2int($str)
    {
        // Normalization phase
        $str = str_replace(['أ', 'إ', 'آ'], 'ا', $str);
        $str = str_replace('ه', 'ة', $str);
        $str = preg_replace('/\s+/', ' ', $str);
        $ptr = ['ـ', 'َ', 'ً', 'ُ', 'ٌ', 'ِ', 'ٍ', 'ْ', 'ّ'];
        $str = str_replace($ptr, '', $str);
        $str = str_replace('مائة', 'مئة', $str);
        $str = str_replace(['احدى', 'احد'], 'واحد', $str);
        $ptr = ['اثنا', 'اثني', 'اثنتا', 'اثنتي'];
        $str = str_replace($ptr, 'اثنان', $str);
        $str = trim($str);

        if (strpos($str, 'ناقص') === false && strpos($str, 'سالب') === false) {
            $negative = false;
        } else {
            $negative = true;
        }

        // Complications process
        $segment = [];
        $max = count($this->_complications);

        for ($scale = $max; $scale > 0; $scale--) {
            $key = pow(1000, $scale);

            $pattern = ['أ', 'إ', 'آ'];
            $format1 = str_replace($pattern, 'ا', $this->_complications[$scale][1]);
            $format2 = str_replace($pattern, 'ا', $this->_complications[$scale][2]);
            $format3 = str_replace($pattern, 'ا', $this->_complications[$scale][3]);
            $format4 = str_replace($pattern, 'ا', $this->_complications[$scale][4]);

            if (strpos($str, $format1) !== false) {
                list($temp, $str) = explode($format1, $str);
                $segment[$key] = 'اثنان';
            } elseif (strpos($str, $format2) !== false) {
                list($temp, $str) = explode($format2, $str);
                $segment[$key] = 'اثنان';
            } elseif (strpos($str, $format3) !== false) {
                list($segment[$key], $str) = explode($format3, $str);
            } elseif (strpos($str, $format4) !== false) {
                list($segment[$key], $str) = explode($format4, $str);
                if ($segment[$key] == '') {
                    $segment[$key] = 'واحد';
                }
            }

            if ($segment[$key] != '') {
                $segment[$key] = trim($segment[$key]);
            }
        }

        $segment[1] = trim($str);

        // Individual process
        $total = 0;
        $subTotal = 0;

        foreach ($segment as $scale => $str) {
            $str = " $str ";
            foreach ($this->_spell as $word => $value) {
                if (strpos($str, "$word ") !== false) {
                    $str = str_replace("$word ", ' ', $str);
                    $subTotal += $value;
                }
            }

            $total   += $subTotal * $scale;
            $subTotal = 0;
        }

        if ($negative) {
            $total = -1 * $total;
        }

        return $total;
    }

    /**
     * Spell integer number in Arabic idiom.
     *
     * @param int     $number The number you want to spell in Arabic idiom
     * @param logical $zero   Present leading zero if true [default is true]
     *
     * @return string The Arabic idiom that spells inserted number
     *
     */
    protected function subInt2str($number, $zero = true)
    {
        $blocks = [];
        $items = [];
        $zeros = '';
        $string = '';
        $number = ($zero != false) ? trim($number) : trim((float) $number);

        if ($number > 0) {

            //--- by Jnom: handle left zero
            // http://www.itkane.com
            // jnom23@gmail.com
            if ($zero != false) {
                $fulnum = $number;
                while (($fulnum[0]) == '0') {
                    $zeros = 'صفر '.$zeros;
                    $fulnum = substr($fulnum, 1, strlen($fulnum));
                }
            }
            //---/

            while (strlen($number) > 3) {
                array_push($blocks, substr($number, -3));
                $number = substr($number, 0, strlen($number) - 3);
            }
            array_push($blocks, $number);

            $blocks_num = count($blocks) - 1;

            for ($i = $blocks_num; $i >= 0; $i--) {
                $number = floor($blocks[$i]);

                $text = $this->writtenBlock($number);
                if ($text) {
                    if ($number == 1 && $i != 0) {
                        $text = $this->_complications[$i][4];
                        if ($this->_order == 2) {
                            $text = 'ال'.$text;
                        }
                    } elseif ($number == 2 && $i != 0) {
                        $text = $this->_complications[$i][$this->_format];
                        if ($this->_order == 2) {
                            $text = 'ال'.$text;
                        }
                    } elseif ($number > 2 && $number < 11 && $i != 0) {
                        $text .= ' '.$this->_complications[$i][3];
                        if ($this->_order == 2) {
                            $text = 'ال'.$text;
                        }
                    } elseif ($i != 0) {
                        $text .= ' '.$this->_complications[$i][4];
                        if ($this->_order == 2) {
                            $text = 'ال'.$text;
                        }
                    }

                    //--- by Jnom: handle left zero
                    if ($text != '' && $zeros != '' && $zero != false) {
                        $text = $zeros.' '.$text;
                        $zeros = '';
                    }
                    //---/

                    array_push($items, $text);
                }
            }

            $string = implode(' و ', $items);
        } else {
            $string = 'صفر';
        }

        return $string;
    }

    /**
     * Spell sub block number of three digits max in Arabic idiom.
     *
     * @param int $number Sub block number of three digits max you want to
     *                    spell in Arabic idiom
     *
     * @return string The Arabic idiom that spells inserted sub block
     *
     */
    protected function writtenBlock($number)
    {
        $items = [];
        $string = '';

        if ($number > 99) {
            $hundred = floor($number / 100) * 100;
            $number = $number % 100;

            if ($this->_order == 2) {
                $pre = 'ال';
            } else {
                $pre = '';
            }

            if ($hundred == 200) {
                array_push(
                    $items,
                    $pre.$this->_individual[$hundred][$this->_format]
                );
            } else {
                array_push($items, $pre.$this->_individual[$hundred]);
            }
        }

        if ($number != 0) {
            if ($this->_order == 2) {
                if ($number <= 10) {
                    array_push($items, $this->_ordering[$number][$this->_feminine]);
                } elseif ($number < 20) {
                    $number -= 10;
                    $item = 'ال'.$this->_ordering[$number][$this->_feminine];

                    if ($this->_feminine == 1) {
                        $item .= ' عشر';
                    } else {
                        $item .= ' عشرة';
                    }

                    array_push($items, $item);
                } else {
                    $ones = $number % 10;
                    $tens = floor($number / 10) * 10;

                    array_push(
                        $items,
                        'ال'.$this->_ordering[$ones][$this->_feminine]
                    );
                    array_push(
                        $items,
                        'ال'.$this->_individual[$tens][$this->_format]
                    );
                }
            } else {
                if ($number == 2 || $number == 12) {
                    array_push(
                        $items,
                        $this->_individual[$number][$this->_feminine][$this->_format]
                    );
                } elseif ($number < 20) {
                    array_push(
                        $items,
                        $this->_individual[$number][$this->_feminine]
                    );
                } else {
                    $ones = $number % 10;
                    $tens = floor($number / 10) * 10;

                    if ($ones == 2) {
                        array_push(
                            $items,
                            $this->_individual[2][$this->_feminine][$this->_format]
                        );
                    } elseif ($ones > 0) {
                        array_push(
                            $items,
                            $this->_individual[$ones][$this->_feminine]
                        );
                    }

                    array_push($items, $this->_individual[$tens][$this->_format]);
                }
            }
        }

        $items = array_diff($items, ['']);
        $string = implode(' و ', $items);

        return $string;
    }

    /**
     * Represent integer number in Arabic-Indic digits using HTML entities.
     *
     * @param int $number The number you want to present in Arabic-Indic digits
     *                    using HTML entities
     *
     * @return string The Arabic-Indic digits represent inserted integer number
     *                using HTML entities
     *
     */
    public function int2indic($number)
    {
        $str = strtr("$number", $this->_arabicIndic);

        return $str;
    }
}

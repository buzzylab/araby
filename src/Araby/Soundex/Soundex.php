<?php

namespace Buzzylab\Aip\Models;

class Soundex
{
    /**
     * @var array
     */
    private $_asoundexCode = [];

    /**
     * @var array
     */
    private $_aphonixCode = [];

    /**
     * @var array
     */
    private $_transliteration = [];

    /**
     * @var array
     */
    private $_map = [];

    /**
     * @var array
     */
    private $_len = 4;

    /**
     * @var array
     */
    private $_lang = 'en';

    /**
     * @var array
     */
    private $_code = 'soundex';

    /**
     * Loads initialize values.
     *
     * @ignore
     */
    public function __construct()
    {
        $xml = simplexml_load_file(__DIR__.'/data/ArSoundex.xml');

        foreach ($xml->asoundexCode->item as $item) {
            $index = $item['id'];
            $value = (string) $item;
            $this->_asoundexCode["$value"] = $index;
        }

        foreach ($xml->aphonixCode->item as $item) {
            $index = $item['id'];
            $value = (string) $item;
            $this->_aphonixCode["$value"] = $index;
        }

        foreach ($xml->transliteration->item as $item) {
            $index = $item['id'];
            $this->_transliteration["$index"] = (string) $item;
        }

        $this->_map = $this->_asoundexCode;
    }

    /**
     * Set the length of soundex key (default value is 4).
     *
     * @param int $integer Soundex key length
     *
     * @return object $this to build a fluent interface
     *
     */
    public function setLen($integer)
    {
        $this->_len = (int) $integer;

        return $this;
    }

    /**
     * Set the language of the soundex key (default value is "en").
     *
     * @param string $str Soundex key language [ar|en]
     *
     * @return object $this to build a fluent interface
     *
     */
    public function setSoundexLang($str)
    {
        $str = strtolower($str);

        if ($str == 'ar' || $str == 'en') {
            $this->_lang = $str;
        }

        return $this;
    }

    /**
     * Set the mapping code of the soundex key (default value is "soundex").
     *
     * @param string $str Soundex key mapping code [soundex|phonix]
     *
     * @return object $this to build a fluent interface
     *
     */
    public function setCode($str)
    {
        $str = strtolower($str);

        if ($str == 'soundex' || $str == 'phonix') {
            $this->_code = $str;
            if ($str == 'phonix') {
                $this->_map = $this->_aphonixCode;
            } else {
                $this->_map = $this->_asoundexCode;
            }
        }

        return $this;
    }

    /**
     * Get the soundex key length used now.
     *
     * @return int return current setting for soundex key length
     *
     */
    public function getLen()
    {
        return $this->_len;
    }

    /**
     * Get the soundex key language used now.
     *
     * @return string return current setting for soundex key language
     *
     */
    public function getLang()
    {
        return $this->_lang;
    }

    /**
     * Get the soundex key calculation method used now.
     *
     * @return string return current setting for soundex key calculation method
     *
     */
    public function getCode()
    {
        return $this->_code;
    }

    /**
     * Methode to get soundex/phonix numric code for given word.
     *
     * @param string $word The word that we want to encode it
     *
     * @return string The calculated soundex/phonix numeric code
     *
     */
    protected function mapCode($word)
    {
        $encodedWord = '';

        $max = mb_strlen($word, 'UTF-8');

        for ($i = 0; $i < $max; $i++) {
            $char = mb_substr($word, $i, 1, 'UTF-8');
            if (isset($this->_map["$char"])) {
                $encodedWord .= $this->_map["$char"];
            } else {
                $encodedWord .= '0';
            }
        }

        return $encodedWord;
    }

    /**
     * Remove any characters replicates.
     *
     * @param string $word Arabic word you want to check if it is feminine
     *
     * @return string Same word without any duplicate chracters
     *
     */
    protected function trimRep($word)
    {
        $lastChar = null;
        $cleanWord = null;
        $max = mb_strlen($word, 'UTF-8');

        for ($i = 0; $i < $max; $i++) {
            $char = mb_substr($word, $i, 1, 'UTF-8');
            if ($char != $lastChar) {
                $cleanWord .= $char;
            }
            $lastChar = $char;
        }

        return $cleanWord;
    }

    /**
     * Arabic soundex algorithm takes Arabic word as an input and produces a
     * character string which identifies a set words that are (roughly)
     * phonetically alike.
     *
     * @param string $word Arabic word you want to calculate its soundex
     *
     * @return string Soundex value for a given Arabic word
     *
     */
    public function soundex($word)
    {
        $soundex = mb_substr($word, 0, 1, 'UTF-8');
        $rest = mb_substr($word, 1, mb_strlen($word, 'UTF-8'), 'UTF-8');

        if ($this->_lang == 'en') {
            $soundex = $this->_transliteration[$soundex];
        }

        $encodedRest = $this->mapCode($rest);
        $cleanEncodedRest = $this->trimRep($encodedRest);

        $soundex .= $cleanEncodedRest;

        $soundex = str_replace('0', '', $soundex);

        $totalLen = mb_strlen($soundex, 'UTF-8');
        if ($totalLen > $this->_len) {
            $soundex = mb_substr($soundex, 0, $this->_len, 'UTF-8');
        } else {
            $soundex .= str_repeat('0', $this->_len - $totalLen);
        }

        return $soundex;
    }
}

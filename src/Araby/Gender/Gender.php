<?php

namespace Buzzylab\Aip\Models;

class Gender
{
    /**
     * Check if Arabic word is feminine.
     *
     * @param string $str Arabic word you would like to check if it is
     *                    feminine
     *
     * @return bool Return true if input Arabic word is feminine
     *
     */
    public function isFemale($str)
    {
        $female = false;

        $words = explode(' ', $str);
        $str = $words[0];

        $str = str_replace(['أ', 'إ', 'آ'], 'ا', $str);

        $last = mb_substr($str, -1, 1, 'UTF-8');
        $beforeLast = mb_substr($str, -2, 1, 'UTF-8');

        if ($last == 'ة' || $last == 'ه' || $last == 'ى' || $last == 'ا' || ($last == 'ء' && $beforeLast == 'ا')) {
            $female = true;
        } elseif (preg_match('/^[اإ].{2}ا.$/u', $str) || preg_match('/^[إا].ت.ا.+$/u', $str)) {
            // الأسماء على وزن إفتعال و إفعال
            $female = true;
        } else {

            // List of the most common irregular Arabic female names
            $names = $this->getJsonData(__DIR__.'/data/female.json');
            $names = array_map('trim', $names);

            if (array_search($str, $names) > 0) {
                $female = true;
            }
        }

        return $female;
    }

    /**
     * Check if Arabic word is note feminine.
     *
     * @param $str
     *
     * @return bool
     */
    public function isMale($str)
    {
        return $this->isFemale($str);
    }
}

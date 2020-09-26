<?php

namespace Araby\Hiero;

class Hiero
{
    private $_language = 'Hiero';

    /**
     * Set the output language.
     *
     * @param string $value Output language (Hiero or Phoenician)
     *
     * @return object $this to build a fluent interface
     *
     */
    public function setLanguage($value)
    {
        $value = strtolower($value);

        if ($value == 'hiero' || $value == 'phoenician') {
            $this->_language = $value;
        }

        return $this;
    }

    /**
     * Get the output language.
     *
     * @return string return current setting of the output language
     *
     */
    public function getLanguage()
    {
        return ucwords($this->_language);
    }

    /**
     * Translate Arabic or English word into Hieroglyphics.
     *
     * @param string $word  Arabic or English word
     * @param string $dir   Writing direction [ltr, rtl, ttd, dtt] (default ltr)
     * @param string $lang  Input language [en, ar] (default en)
     * @param int    $red   Value of background red component (default is null)
     * @param int    $green Value of background green component (default is null)
     * @param int    $blue  Value of background blue component (default is null)
     *
     * @return resource Image resource identifier
     *
     */
    public function str2graph($word, $dir = 'ltr', $lang = 'en', $red = null, $green = null, $blue = null)
    {
        if ($this->_language == 'phoenician') {
            define(MAXH, 40);
            define(MAXW, 50);
        } else {
            define(MAXH, 100);
            define(MAXW, 75);
        }

        // Note: there is no theh, khah, thal, dad, zah, and ghain in Phoenician
        $arabic = [
            'ا' => 'alef',
            'ب' => 'beh',
            'ت' => 'teh',
            'ث' => 'theh',
            'ج' => 'jeem',
            'ح' => 'hah',
            'خ' => 'khah',
            'د' => 'dal',
            'ذ' => 'thal',
            'ر' => 'reh',
            'ز' => 'zain',
            'س' => 'seen',
            'ش' => 'sheen',
            'ص' => 'sad',
            'ض' => 'dad',
            'ط' => 'tah',
            'ظ' => 'zah',
            'ع' => 'ain',
            'غ' => 'ghain',
            'ف' => 'feh',
            'ق' => 'qaf',
            'ك' => 'kaf',
            'ل' => 'lam',
            'م' => 'meem',
            'ن' => 'noon',
            'ه' => 'heh',
            'و' => 'waw',
            'ي' => 'yeh',
        ];

        if ($lang != 'ar' && $this->_language == 'phoenician') {
            $temp = new Transliteration();
            $word = $temp->en2ar($word);

            $temp = null;
            $lang = 'ar';
        }

        if ($lang != 'ar') {
            $word = strtolower($word);
        } else {
            $word = str_replace('ة', 'ت', $word);
            $alef = ['ى', 'ؤ', 'ئ', 'ء', 'آ', 'إ', 'أ'];
            $word = str_replace($alef, '?', $word);
        }

        $chars = [];
        $max = mb_strlen($word, 'UTF-8');

        for ($i = 0; $i < $max; $i++) {
            $chars[] = mb_substr($word, $i, 1, 'UTF-8');
        }

        if ($dir == 'rtl' || $dir == 'btt') {
            $chars = array_reverse($chars);
        }

        $max_w = 0;
        $max_h = 0;

        foreach ($chars as $char) {
            if ($lang == 'ar') {
                $char = $arabic[$char];
            }

            if (file_exists(__DIR__."/data/{$this->_language}/$char.gif")) {
                list($width, $height) = getimagesize(__DIR__."/data/{$this->_language}/$char.gif");
            } else {
                $width = MAXW;
                $height = MAXH;
            }

            if ($dir == 'ltr' || $dir == 'rtl') {
                $max_w += $width;
                if ($height > $max_h) {
                    $max_h = $height;
                }
            } else {
                $max_h += $height;
                if ($width > $max_w) {
                    $max_w = $width;
                }
            }
        }

        $im = imagecreatetruecolor($max_w, $max_h);

        if ($red == null) {
            $bck = imagecolorallocate($im, 0, 0, 255);
            imagefill($im, 0, 0, $bck);

            // Make the background transparent
            imagecolortransparent($im, $bck);
        } else {
            $bck = imagecolorallocate($im, $red, $green, $blue);
            imagefill($im, 0, 0, $bck);
        }

        $current_x = 0;
        $current_y = 0;

        foreach ($chars as $char) {
            if ($lang == 'ar') {
                $char = $arabic[$char];
            }
            $filename = __DIR__."/data/{$this->_language}/$char.gif";

            if ($dir == 'ltr' || $dir == 'rtl') {
                if (file_exists($filename)) {
                    list($width, $height) = getimagesize($filename);

                    $image = imagecreatefromgif($filename);
                    imagecopy(
                        $im, $image, $current_x, $max_h - $height,
                        0, 0, $width, $height
                    );
                } else {
                    $width = MAXW;
                }

                $current_x += $width;
            } else {
                if (file_exists($filename)) {
                    list($width, $height) = getimagesize($filename);

                    $image = imagecreatefromgif($filename);
                    imagecopy($im, $image, 0, $current_y, 0, 0, $width, $height);
                } else {
                    $height = MAXH;
                }

                $current_y += $height;
            }
        }

        return $im;
    }
}

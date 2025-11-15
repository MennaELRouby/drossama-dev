<?php

namespace App\Helper;

class StringHelper
{
    /**
     * Fix Arabic mojibake encoding issues
     *
     * @param string $text
     * @return string
     */
    public static function fixArabicMojibake($text)
    {
        if (empty($text)) {
            return $text;
        }

        // Try safe encoding conversion
        $supportedEncodings = ['ISO-8859-6', 'UTF-8'];
        foreach ($supportedEncodings as $encoding) {
            if (mb_check_encoding($text, $encoding)) {
                $converted = @mb_convert_encoding($text, 'UTF-8', $encoding);
                if ($converted && $converted !== $text && mb_strlen($converted) > 0) {
                    $text = $converted;
                    break;
                }
            }
        }

        // Common mojibake pattern fixes
        $patterns = [
            'Ø§' => 'ا',
            'Ø¨' => 'ب',
            'Øª' => 'ت',
            'Ø«' => 'ث',
            'Ø¬' => 'ج',
            'Ø' => 'ح',
            'Ø®' => 'خ',
            'Ø¯' => 'د',
            'Ø°' => 'ذ',
            'Ø±' => 'ر',
            'Ø²' => 'ز',
            'Ø³' => 'س',
            'Ø´' => 'ش',
            'Øµ' => 'ص',
            'Ø¶' => 'ض',
            'Ø·' => 'ط',
            'Ø¸' => 'ظ',
            'Ø¹' => 'ع',
            'Øº' => 'غ',
            'Ø¡' => 'ء',
            'Ø¢' => 'آ',
            'Ø£' => 'أ',
            'Ø¥' => 'إ',
            'Ø¦' => 'ئ',
            'Ø®Ù' => 'خد',
            'Ø§Ø®Ø¯' => 'اخد',
            'Ù%C2%85' => 'ة'
        ];

        return str_replace(array_keys($patterns), array_values($patterns), $text);
    }
}

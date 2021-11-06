<?php

namespace Maniruzzaman\Sanitizer\Formatter;

use Maniruzzaman\Sanitizer\Interfaces\FormatterInterface;

/**
 * Utf-8 Formatter.
 *
 * @since 0.0.1
 *
 * Formats the given string to utf-8.
 */
class Utf8Formatter implements FormatterInterface
{
    /**
     * Format an invalid UTF8 in a string.
     *
     * @since 0.0.1
     *
     * @param string $string The text which is to be checked.
     * @param bool   $strip  Optional. Whether to attempt to strip out invalid UTF8. Default false.
     *
     * @return string The checked text.
     */
    public function format($string, $strip = false)
    {
        $string = (string) $string;

        if (0 === strlen($string)) {
            return '';
        }

        // Check for support for utf8 in the installed PCRE library once and store the result in a static.
        static $utf8_pcre = null;
        if (!isset($utf8_pcre)) {
            $utf8_pcre = @preg_match('/^./u', 'a');
        }

        // We can't demand utf8 in the PCRE installation, so just return the string in those cases.
        if (!$utf8_pcre) {
            return $string;
        }

        // preg_match fails when it encounters invalid UTF8 in $string.
        if (1 === @preg_match('/^./us', $string)) {
            return $string;
        }

        // Attempt to strip the bad chars if requested (not recommended).
        if ($strip && function_exists('iconv')) {
            return iconv('utf-8', 'utf-8', $string);
        }

        return '';
    }
}

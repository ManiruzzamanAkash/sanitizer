<?php

namespace ManiruzzamanAkash\Sanitizer;

use ManiruzzamanAkash\Sanitizer\Formatter\Utf8Formatter;

/**
 * Sanitize Main class.
 *
 * @author Maniruzzaman Akash <manirujjamanakash@gmail.com>
 * @package ManiruzzamanAkash\Sanitize
 *
 * @version 0.0.1
 */
final class Sanitize
{

    /**
     * Sanitizes the given data.
     *
     * @var Utf8Formatter
     */
    public $Utf8Formatter;

    /**
     * Constuctor.
     *
     * @param Utf8Formatter $Utf8Formatter
     */
    public function __construct()
    {
        $this->Utf8Formatter = new Utf8Formatter();
    }


    /**
     * Create a function to sanitize the input.
     *
     * @since 0.0.1
     *
     * @param string $data
     *
     * @return void
     */
    public static function text($text)
    {
        //trim data
        $text = trim($text);

        //strip tags
        $text = strip_tags($text);

        //stripslashes
        $text = stripslashes($text);

        //htmlspecialchars
        $text = htmlspecialchars($text);

        return $text;
    }

    /**
     * Create a function to sanitize the input.
     *
     * @since 0.0.1
     *
     * @param stromg $attr
     *
     * @return sanitized string
     */
    public function attr($attr)
    {
        // If attribute is empty, return empty string
        if (empty($attr)) {
            return '';
        }

        // If attribute is an array, sanitize each value
        if (is_array($attr)) {
            return array_map(array($this, 'sanitize_attr'), $attr);
        }

        // If attribute is a string, sanitize it
        $safe_text = $this->Utf8Formatter->format($attr);

        // Get stpec

        return $safe_text;
    }
}

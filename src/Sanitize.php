<?php

namespace Maniruzzaman\Sanitizer;

use Maniruzzaman\Sanitizer\Formatter\Utf8Formatter;

/**
 * Sanitize Main class.
 *
 * @author Maniruzzaman Akash <manirujjamanakash@gmail.com>
 * @package Maniruzzaman\Sanitize
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

        return $safe_text;
    }

    /**
     * Checks and cleans a URL.
     *
     * A number of characters are removed from the URL. If the URL is for displaying
     * (the default behaviour) ampersands are also replaced.
     *
     * @since 0.0.2
     *
     * @param string   $url       The URL to be cleaned.
     * @param string[] $protocols Optional. An array of acceptable protocols.
     *                            Defaults to return value of get_allowed_protocols().
     * @param string   $visibility  Private. Use for database usage.
     * @return string  $clean_url
     */
    public function url($url, $protocols = null, $visibility = 'display')
    {
        $original_url = $url;

        if ('' === $url) {
            return $url;
        }

        $url = str_replace(' ', '%20', ltrim($url));
        $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\[\]\\x80-\\xff]|i', '', $url);

        if ('' === $url) {
            return $url;
        }

        if (0 !== stripos($url, 'mailto:')) {
            $strip = array('%0d', '%0a', '%0D', '%0A');
            $url   = _deep_replace($strip, $url);
        }

        $url = str_replace(';//', '://', $url);

        /*
        * If the URL doesn't appear to contain a scheme, we presume
        * it needs http:// prepended (unless it's a relative link
        * starting with /, # or ?, or a PHP file).
        */
        if (
            strpos($url, ':') === false && !in_array($url[0], array('/', '#', '?'), true) &&
            !preg_match('/^[a-z0-9-]+?\.php/i', $url)
        ) {
            $url = 'http://' . $url;
        }

        // Replace ampersands and single quotes only when displaying.
        if ('display' === $visibility) {
            // $url = normalize_entities($url); // @todo implement this in later version
            $url = str_replace('&amp;', '&#038;', $url);
            $url = str_replace("'", '&#039;', $url);
        }

        if ((false !== strpos($url, '[')) || (false !== strpos($url, ']'))) {

            $parsed = parse_url_string($url);
            $front  = '';

            if (isset($parsed['scheme'])) {
                $front .= $parsed['scheme'] . '://';
            } elseif ('/' === $url[0]) {
                $front .= '//';
            }

            if (isset($parsed['user'])) {
                $front .= $parsed['user'];
            }

            if (isset($parsed['pass'])) {
                $front .= ':' . $parsed['pass'];
            }

            if (isset($parsed['user']) || isset($parsed['pass'])) {
                $front .= '@';
            }

            if (isset($parsed['host'])) {
                $front .= $parsed['host'];
            }

            if (isset($parsed['port'])) {
                $front .= ':' . $parsed['port'];
            }

            $end_dirty = str_replace($front, '', $url);
            $end_clean = str_replace(array('[', ']'), array('%5B', '%5D'), $end_dirty);
            $url       = str_replace($end_dirty, $end_clean, $url);
        }

        if ('/' === $url[0]) {
            $good_protocol_url = $url;
        } else {
            if (!is_array($protocols)) {
                $protocols = get_allowed_protocols();
            }
        }

        return $url;
    }
}

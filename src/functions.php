<?php

/**
 * Deep replace of strings in an array or string.
 *
 * @since 0.0.2
 *
 * @param string $subject
 * @param string $search
 *
 * @return string The processed string.
 */
function _deep_replace($subject, $search)
{
    $subject = (string) $subject;

    $count = 1;
    while ($count) {
        $subject = str_replace($search, '', $subject, $count);
    }

    return $subject;
}

/**
 * A wrapper for PHP's parse_url() function that handles consistency in the return
 * values across PHP versions.
 *
 * PHP 5.4.7 expanded parse_url()'s ability to handle non-absolute url's, including
 * schemeless and relative url's with :// in the path. This function works around
 * those limitations providing a standard output on PHP 5.2~5.4+.
 *
 * Secondly, across various PHP versions, schemeless URLs starting containing a ":"
 * in the query are being handled inconsistently. This function works around those
 * differences as well.
 *
 * @since 0.0.2
 *
 * @link https://www.php.net/manual/en/function.parse-url.php
 *
 * @param string $url       The URL to parse.
 * @param int    $component The specific component to retrieve. Use one of the PHP
 *                          predefined constants to specify which one.
 *                          Defaults to -1 (= return all parts as an array).
 * @return mixed False on parse failure; Array of URL components on success;
 *               When a specific component has been requested: null if the component
 *               doesn't exist in the given URL; a string or - in the case of
 *               PHP_URL_PORT - integer when it does. See parse_url()'s return values.
 */
function parse_url_string($url, $component = -1)
{
    $to_unset = array();
    $url      = (string) $url;

    if ('//' === substr($url, 0, 2)) {
        $to_unset[] = 'scheme';
        $url        = 'placeholder:' . $url;
    } elseif ('/' === substr($url, 0, 1)) {
        $to_unset[] = 'scheme';
        $to_unset[] = 'host';
        $url        = 'placeholder://placeholder' . $url;
    }

    $parts = parse_url($url);

    if (false === $parts) {
        // Parsing failure.
        return $parts;
    }

    // Remove the placeholder values.
    foreach ($to_unset as $key) {
        unset($parts[$key]);
    }

    return _get_component_from_parsed_url($parts, $component);
}

/**
 * Retrieve a specific component from a parsed URL array.
 *
 * @internal
 *
 * @since 0.0.2
 * @access private
 *
 * @link https://www.php.net/manual/en/function.parse-url.php
 *
 * @param array|false $url_parts The parsed URL. Can be false if the URL failed to parse.
 * @param int         $component The specific component to retrieve. Use one of the PHP
 *                               predefined constants to specify which one.
 *                               Defaults to -1 (= return all parts as an array).
 * @return mixed False on parse failure; Array of URL components on success;
 *               When a specific component has been requested: null if the component
 *               doesn't exist in the given URL; a string or - in the case of
 *               PHP_URL_PORT - integer when it does. See parse_url()'s return values.
 */
function _get_component_from_parsed_url($url_parts, $component = -1)
{
    if (-1 === $component) {
        return $url_parts;
    }

    $key = _translate_php_url_constant_to_key($component);

    if (false !== $key && is_array($url_parts) && isset($url_parts[$key])) {
        return $url_parts[$key];
    } else {
        return null;
    }
}

/**
 * Translate a PHP_URL_* constant to the named array keys PHP uses.
 *
 * @internal
 *
 * @since 0.0.2
 * @access private
 *
 * @link https://www.php.net/manual/en/url.constants.php
 *
 * @param int $constant PHP_URL_* constant.
 * @return string|false The named key or false.
 */
function _translate_php_url_constant_to_key($constant)
{
    $translation = array(
        PHP_URL_SCHEME   => 'scheme',
        PHP_URL_HOST     => 'host',
        PHP_URL_PORT     => 'port',
        PHP_URL_USER     => 'user',
        PHP_URL_PASS     => 'pass',
        PHP_URL_PATH     => 'path',
        PHP_URL_QUERY    => 'query',
        PHP_URL_FRAGMENT => 'fragment',
    );

    if (isset($translation[$constant])) {
        return $translation[$constant];
    } else {
        return false;
    }
}

/**
 * Get allowed protocols for URLs.
 *
 * @since 0.0.2
 *
 * @return array Array of allowed protocols.
 */
function get_allowed_protocols()
{
    return array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'irc6', 'ircs', 'gopher', 'nntp', 'feed', 'telnet', 'mms', 'rtsp', 'sms', 'svn', 'tel', 'fax', 'xmpp', 'webcal', 'urn');
}

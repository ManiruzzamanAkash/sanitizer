<?php

namespace Maniruzzaman\Sanitizer\Formatter;

/**
 * Interface FormatterInterface.
 *
 * @package Maniruzzaman\Sanitizer\Formatter
 * @author  Maniruzzaman Akash <manirujjamanakash@gmail.com>
 */
interface FormatterInterface
{
    /**
     * Format the given value.
     *
     * @since 0.0.1
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function format($value);
}

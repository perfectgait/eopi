<?php

namespace EOPI\Helper;

/**
 * Class InputHelper
 *
 * @package EOPI\Helper
 */
class InputHelper
{
    /**
     * Read input from stdin
     *
     * @param null|string $message
     * @return string
     */
    public function readInputFromStdIn($message = null)
    {
        if (!is_null($message)) {
            print $message;
        }

        $handle = fopen('php://stdin', 'r');
        $value = fgets($handle);
        fclose($handle);

        return trim($value);
    }
}
<?php

namespace EOPI\Helper;

/**
 * Class OutputHelper
 *
 * @package EOPI\Helper
 */
class OutputHelper
{
    /**
     * Print an array formatted as rows and columns to stdout
     *
     * @param $array
     */
    public function printFormattedArrayToStdOut($array)
    {
        for ($i = 0; $i < count($array); $i++) {
            print '[';

            for ($j = 0; $j < count($array[$i]); $j++) {
                print $array[$i][$j];

                if ($j != count($array[$i]) - 1) {
                    print ',';
                }
            }

            print ']' . PHP_EOL;
        }
    }
}
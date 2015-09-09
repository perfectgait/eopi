<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) where n is the length of the string
 */

/**
 * Compute a spreadsheet column encoding.  This works by converting a base 26 number to a decimal (base 10).  The
 * difference is that the string is read from left to right when converting.
 * i.e.
 * ABCD = 1234 in base 26
 * = 1 * 26^0 + 2 * 26^1 + 3 * 26^2 + 4 * 26^3
 * = 1 * 1    + 2 * 26   + 3 * 676  + 4 * 17576
 * = 1        + 52       + 2028     + 70304
 * = 72385
 *
 * ZZ
 * = 26 * 26^0 + 26 * 26^1
 * = 26 * 1    + 26 * 26
 * = 26        + 676
 * = 702
 *
 * @param string $column
 * @return int|string
 */
function computeSpreadhseetColumnEncoding($column)
{
    $result = 0;
    $characterMapping = [
        'A' => 1,
        'B' => 2,
        'C' => 3,
        'D' => 4,
        'E' => 5,
        'F' => 6,
        'G' => 7,
        'H' => 8,
        'I' => 9,
        'J' => 10,
        'K' => 11,
        'L' => 12,
        'M' => 13,
        'N' => 14,
        'O' => 15,
        'P' => 16,
        'Q' => 17,
        'R' => 18,
        'S' => 19,
        'T' => 20,
        'U' => 21,
        'V' => 22,
        'W' => 23,
        'X' => 24,
        'Y' => 25,
        'Z' => 26,
    ];

    for ($i = strlen($column) - 1; $i >= 0; $i--) {
        $result = $result * 26 + $characterMapping[$column[$i]];

        if ($result > PHP_INT_MAX || $result < 0) {
            return INF;
        }
    }

    return $result;
}

$inputHelper = new InputHelper();
$string = $inputHelper->readInputFromStdIn('Enter the column id as a string (i.e. A or AA or B): ');
$result = computeSpreadhseetColumnEncoding(strtoupper($string));
printf('The column encoding of %s is %s', $string, $result);
print PHP_EOL;
<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) where n is the length of the string
 */

/**
 * Compute a spreadsheet column encoding.  In this variant A corresponds to 0.  This is similar to the stock example
 * however by allowing A to be 0 we can skip exponents.
 * i.e.
 * GBAF = 6105 in base 26
 * = 6 * 26^0 + 1 * 26^1 + 0 * 26^2 + 5 * 26^3
 * = 6 * 1    + 1 * 26   + 0 * 676  + 5 * 17576
 * = 6        + 26       + 0        + 87880
 * = 87912
 *
 * AAZN = 0 0 25 13 (spaces only for distinction) in base 26
 * = 0 * 26^0 + 0 * 26^1 + 25 * 26^2 + 13 * 26^3
 * = 0 * 1    + 0 * 26   + 25 * 676  + 13 * 17576
 * = 0        + 0        + 16900     + 228488
 * = 245388
 *
 * @param string $column
 * @return int|string
 */
function computeSpreadhseetColumnEncoding($column)
{
    $result = 0;
    $characterMapping = [
        'A' => 0,
        'B' => 1,
        'C' => 2,
        'D' => 3,
        'E' => 4,
        'F' => 5,
        'G' => 6,
        'H' => 7,
        'I' => 8,
        'J' => 9,
        'K' => 10,
        'L' => 11,
        'M' => 12,
        'N' => 13,
        'O' => 14,
        'P' => 15,
        'Q' => 16,
        'R' => 17,
        'S' => 18,
        'T' => 19,
        'U' => 20,
        'V' => 21,
        'W' => 22,
        'X' => 23,
        'Y' => 24,
        'Z' => 25,
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
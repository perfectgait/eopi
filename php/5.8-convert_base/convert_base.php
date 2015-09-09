<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n(1 + log(base base2)base1)), where n is the length of s.  The reasoning is as follows.
First, we perform n multiply-and-adds to get x from s.  Then we perform log(base base2)x multiply and adds to get
the result.  The value x is upper-bounded by base1^n, and log(base base 2)base1^n = nlog(base base2)base1
 */

/**
 * Convert a number from one base to another.  This works by first converting the number to a decimal (base 10).  Once
 * the number is in decimal, it is converted to the new base.
 * To convert to decimal multiply each digit of the original number, multiply each value by the base raised to k.  For
 * example 173 in base 5 becomes 3 * 5^0 + 7 * 5^1 + 1 * 5^2 or 3 * 1 + 7 * 5 + 1 * 25 or 3 + 35 + 25 or 63.
 * To convert from decimal to the new base, go divide the decimal by the new base and find the remainder then add that
 * to the new number.  Do this until the decimal is <= 0.  Then reverse the new number because the values were added in
 * reverse order.  For example if the decimal is 63 and the new base is 8:
 * 63 % 8 is 7 and floor(63 / 8) = 7
 * 7 % 8 is 7 and 7 / 8 is less than 0
 * The new number is 77
 * To handle values larger than 9 this uses the translation array.
 *
 * @param string $number
 * @param int $base1
 * @param int $base2
 * @return string
 * @throws \InvalidArgumentException
 * @throws \OutOfRangeException
 */
function convertBase($number, $base1, $base2)
{
    if (!is_int($base1)) {
        throw new \InvalidArgumentException('$base1 must be an integer');
    }

    if ($base1 < 2 || $base1 > 16) {
        throw new \OutOfRangeException('$base1 must be between 2 and 16 inclusive');
    }

    if (!is_int($base2)) {
        throw new \InvalidArgumentException('$base2 must be an integer');
    }

    if ($base2 < 2 || $base2 > 16) {
        throw new \OutOfRangeException('$base2 must be between 2 and 16 inclusive');
    }

    $isNegative = $number[0] == '-';
    $characterTranslations = [
        'A' => 10,
        'B' => 11,
        'C' => 12,
        'D' => 13,
        'E' => 14,
        'F' => 15,
    ];
    $valueTranslations = array_flip($characterTranslations);

    // Convert the number to decimal (base 10)
    $decimal = 0;

    for ($i = ($isNegative ? 1 : 0); $i < strlen($number); $i++) {
        $decimal *= $base1;
        $decimal += is_numeric($number[$i]) ? (int)$number[$i] : $characterTranslations[$number[$i]];
    }

    if (!is_integer($decimal)) {
        throw new \OutOfRangeException('converting to decimal produced a number that is too large');
    }

    // Convert the decimal to the new base
    $newNumber = '';

    while ($decimal) {
        $remainder = $decimal % $base2;
        $newNumber .= $remainder < 10 ? $remainder : $valueTranslations[$remainder];
        $decimal = (int)($decimal / $base2);
    }

    if ($isNegative) {
        $newNumber .= '-';
    }

    return strrev($newNumber);
}

$inputHelper = new InputHelper();
$number = $inputHelper->readInputFromStdIn('Enter the string in base 1: ');
$base1 = $inputHelper->readInputFromStdIn('Enter the integer base 1 between 2 and 16 inclusive: ');
$base2 = $inputHelper->readInputFromStdIn('Enter the integer base 2 between 2 and 16 inclusive: ');
$result = convertBase((string)trim($number), (int)$base1, (int)$base2);
printf('The result of converting %s from base %d to %d is: %s', $number, $base1, $base2, $result);
print PHP_EOL;
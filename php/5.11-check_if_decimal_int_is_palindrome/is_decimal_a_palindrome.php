<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n), where n is the number of digits in x.
 */

/**
 * Determine if the integer is palindromic.  This works by comparing the first and last digit using division and modulo.
 * If the numbers match at that iteration, the original number is reduced by a factor of 10 and
 *
 * For example if the number is 9587:
 * $numberOfDigits = 4
 * $msdShift = 1000
 *
 * Iteration 1:
 * 9587 / 1000 = 9.587 rounded to 9
 * 9587 % 10 = 7
 * 9 != 7 so 9587 is not a palindrome
 *
 * If the number is 8558:
 * $numberOfDigits
 *
 * @param $integer
 * @return bool
 */
function isPalindromic($integer)
{
    if (!is_numeric($integer)) {
        throw new \InvalidArgumentException('$integer must be a number');
    }

    $integer = (int)$integer;

    if ($integer < 0) {
        return false;
    }

    if ($integer === 0) {
        return true;
    }

    $numberOfDigits = floor(log10($integer)) + 1;
    $integerRemaining = $integer;
    $msdShift = pow(10, $numberOfDigits - 1);

    for ($i = 0; $i < ($numberOfDigits / 2); $i++) {
        if ((int)($integer / $msdShift) != (int)($integerRemaining % 10)) {
            return false;
        }

        $integer %= $msdShift;
        $msdShift /= 10;
        $integerRemaining /= 10;
    }

    return true;
}

$inputHelper = new InputHelper();
$integer = $inputHelper->readInputFromStdIn('Enter the integer to test: ');
$result = isPalindromic($integer);

if ($result === true) {
    printf('The integer %d is palindromic', $integer);
} else {
    printf('The integer %d is not palindromic', $integer);
}

print PHP_EOL;
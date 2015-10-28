<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n), where n is the number of digits in x.
 */

/**
 * Determine if the integer is palindromic.  This works by comparing the most significant and least significant digits
 * at each iteration for equality.  If they are equal it keeps iterating.  If it makes it half-way through the integer
 * with no differences, the integer is palindromic.
 * The most significant digit is found by dividing the integer by 10^the number of digits in the integer.  If the
 * integer is 98789 then the number of digits is 5, then 98789 is divided by 10^4(10000).  This results in
 * 98789 / 10000 = 9.8789.  This value is treated as an integer so it's just 9.
 * The least significant digit is found by calculating the modulo of the integer and 10.  If the integer is 98789 then
 * this results in 98789 % 10 = 9.
 * If the digits match in an iteration then the modulo of the original iterator and 10^the number of digits in the
 * integer is found.  This becomes the new integer value.  If the integer is 98789 then this results in 98789 % 10000 =
 * 8789.  Then the copy of the original integer is divided by 10 to remove the least significant digit.  If the copy of
 * the original integer is 98789 this results in 98789 / 10 = 9878.9.  This is treated as an integer so it's just 9878.
 * After this happens we have two new integers, 8789 and 9878 which are the result of the original integer 98789 with
 * the most significant and least significant digits stripped, respectively.
 *
 * If the number is 98789:
 * $numberOfDigits = 5
 * $msdShift = 10000
 *
 * Iteration 1:
 * 98789 / 10000 = 9.8789 rounded to 9 AND 98789 % 10 = 9 so we continue
 * $integer = 98789 % 10000 = 8789
 * $msdShift = 10000 / 10 = 1000
 * $integerRemaining = 98789 / 10 = 9878
 *
 * Iteration 2:
 * 8789 / 1000 = 8.789 rounded to 8 AND 9878 % 10 = 8 so we continue
 * $integer = 8789 % 1000 = 789
 * $msdShift = 1000 / 10 = 100
 * $integerRemaining = 9878 / 10 = 987
 *
 * Iteration 3:
 * 789 / 100 = 7.89 rounded to 7 AND 987 % 10 = 7 so we continue
 * $integer = 789 % 100 = 89
 * $msdShift = 100 / 10 = 10
 * $integerRemaining = 987 / 10 = 98
 *
 * Iteration 4:
 * 89 / 10 = 8.9 rounded to 8 AND 98 % 10 = 8 so we continue
 * $integer = 89 % 10 = 9
 * $msdShift = 10/10 = 1
 * $integerRemaining = 98 / 10 = 9
 *
 * We have reached the middle so we are done, 98789 is palindromic
 *
 *
 * If the number is 9587:
 * $numberOfDigits = 4
 * $msdShift = 1000
 *
 * Iteration 1:
 * 9587 / 1000 = 9.587 rounded to 9 AND 9587 % 10 = 7 so 9587 is not a palindrome
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
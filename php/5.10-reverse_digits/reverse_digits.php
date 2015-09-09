<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) where n is the number of digits in K
 */

/**
 * Reverse the digits in a number.  This works by taking the remainder of the number / 10 and adding that to the new
 * number.  Then the new number is multiplied by 10 to move the value to the left by 1.  The original number is then
 * divided by 10.  This happens until the original number is <= 0.
 * i.e.
 * 12345
 *
 * Iteration 1:
 * $result = 5 (0 * 10 + 12345 % 10)
 * $number = 1234.5
 *
 * Iteration 2:
 * $result = 54 (5 * 10 + 1234.5 % 10)
 * $number = 123.45
 *
 * Iteration 3:
 * $result = 543 (54 * 10 + 123.45 % 10)
 * $number = 12.345
 *
 * Iteration 4:
 * $result = 5432 (543 * 10 + 12.345 % 10)
 * $number = 1.2345
 *
 * Iteration 5:
 * $result = 54321 (5432 * 10 + 1.2345 % 10)
 * $number = 0.12345
 *
 * @param int $number
 * @return int
 * @throws \InvalidArgumentException
 */
function reverseDigits($number)
{
    if (!is_int($number)) {
        throw new \InvalidArgumentException('$number must be an integer');
    }

    $isNegative = $number < 0;
    $number = abs($number);
    $result = 0;

    while ($number >= 1) {
        $result = $result * 10 + $number % 10;
        // Known issue, working with very large numbers will cause issues.  i.e. PHP_INT_MAX
        $number = ($number / 10);
    }

    if ($isNegative) {
        $result *= -1;
    }

    return $result;
}

$inputHelper = new InputHelper();
$number = $inputHelper->readInputFromStdIn('Enter the integer to reverse: ');
$result = reverseDigits((int)$number);
printf('The result of reversing the digits in %d is: %d', (int)$number, $result);
print PHP_EOL;
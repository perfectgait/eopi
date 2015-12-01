<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n * m) where n and m are the lengths of the two inputs
 */

/**
 * Multiply two big integers represented by strings.  This works by multiplying each digit of the first number by each
 * digit of the second number and incrementally adding the result.  As the results are added, if the current index value
 * is greater than 10 the value greater than 10 is carried over to the next index.  i.e. if index 1 is 100 then 10 would
 * be carried over to index 2 by dividing 100 by 10.  Then the modulo of the current index by 10 is found to ensure that
 * the current index is less than 10.  i.e. if index 1 is 253 then 25 is carried over and 3 is left because 253 % 10 = 3.
 *
 * i.e.
 *
 * If 89 is multiplied by 98
 *
 * $isPositive = true
 * $number1 = 98
 * $number2 = 89
 * $result = [0, 0, 0, 0]
 *
 * Iteration 1:
 * $i = 0
 * $j = 0
 * $result = [72, 0, 0, 0]
 * $result = [72, 7, 0, 0]
 * $result = [2, 7, 0, 0]
 *
 * Iteration 2:
 * $i = 0
 * $j = 1
 * $result = [2, 88, 0, 0]
 * $result = [2, 88, 8, 0]
 * $result = [2, 8, 8, 0]
 *
 * Iteration 3:
 * $i = 1
 * $j = 0
 * $result = [2, 72, 8, 0]
 * $result = [2, 72, 15, 0]
 * $result = [2, 2, 15, 0]
 *
 * Iteration 4:
 * $i = 1
 * $j = 1
 * $result = [2, 2, 87, 0]
 * $result = [2, 2, 87, 8]
 * $result = [2, 2, 7, 8]
 *
 * After $result is reversed
 * $result = [8, 7, 2, 2]
 *
 * @param string $number1
 * @param string $number2
 * @return string
 */
function multiplyTwoBigIntegers($number1, $number2)
{
    $isPositive = true;

    if ($number1[0] == '-') {
        $isPositive = !$isPositive;
        $number1 = substr($number1, 1);
    }

    if ($number2[0] == '-') {
        $isPositive = !$isPositive;
        $number2 = substr($number2, 1);
    }

    // Reverse the numbers so it is easier to work with them
    $number1 = strrev($number1);
    $number2 = strrev($number2);
    $result = array_fill(0, strlen($number1) + strlen($number2), 0);

    for ($i = 0; $i < strlen($number1); $i++) {
        for ($j = 0; $j < strlen($number2); $j++) {
            $result[$i + $j] += (int)$number1[$i] * (int)$number2[$j];
            // If the result is greater than 10, carry over
            $result[$i + $j + 1] += (int)($result[$i + $j] / 10);
            // If the result is greater than 10, keep this index to single a digit
            $result[$i + $j] %= 10;
        }
    }

    $k = strlen($number1) + strlen($number2) - 1;

    // Remove any leading 0's and keep one zero if the result is just 0
    while ($result[$k] == 0 && $k != 0) {
        unset($result[$k--]);
    }

    return (string)(!$isPositive ? '-' : null) . implode('', array_reverse($result));
}

$inputHelper = new InputHelper();
$number1 = $inputHelper->readInputFromStdIn('Enter the first integer: ');
$number2 = $inputHelper->readInputFromStdIn('Enter the second integer: ');
$result = multiplyTwoBigIntegers($number1, $number2);

printf('The product of %s and %s is %s.', $number1, $number2, $result);
print PHP_EOL;
<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) where n is the width of the first number being multiplied
 */

/**
 * Compute multiplication without using built-in multiplication
 *
 * This works by going through each bit of $number1.  When a bit is toggled then the sum is increased by 2^k*$number2
 * (this is achieved by shifting $number to the left 1 bit in each iteration effectively multiplying it by 2)
 * i.e.
 * 110 (6) * 11 (3) = 10010 (18)
 *
 * Iteration 1:
 * First bit of 110 is not set so sum is 0
 * $number1 = 11 (3)
 * $number2 = 110 (6)
 * $sum = 0
 *
 * Iteration 2:
 * First bit of 11 is set so sum is increased by 6
 * $number1 = 1 (1)
 * $number2 = 1100 (12)
 * $sum = 6
 *
 * Iteration 3:
 * First bit of 1 is set so sum is increased by 12
 * $number1 = 0 (0)
 * $number2 = 11000 (24)
 * $sum = 18
 *
 * @param int $number1
 * @param int $number2
 * @return int
 */
function computeMultiplicationWithoutMultiplyOrAdd($number1, $number2)
{
    if (!is_int($number1)) {
        throw new \InvalidArgumentException('$number1 must be an integer');
    }

    if ($number1 < 0) {
        throw new \InvalidArgumentException('$number1 must be non-negative');
    }

    if (!is_int($number2)) {
        throw new \InvalidArgumentException('$number2 must be an integer');
    }

    if ($number2 < 0) {
        throw new \InvalidArgumentException('$number2 must be non-negative');
    }

    printf('Performing %b * %b', $number1, $number2);
    print PHP_EOL;
    $sum = 0;

//    printf('%b(%d) %b(%d)', $number1, $number1, $number2, $number2);
//    print PHP_EOL;

    while ($number1) {
        printf('%b(%d) %b(%d)', $number1, $number1, $number2, $number2);

        if ($number1 & 1) {
            $sum = computeAdditionWithoutAdd($sum, $number2);
//            print $number2 . ' + ';
            print ' = ' . $sum . PHP_EOL;
        } else {
            print PHP_EOL;
        }

        $number1 >>= 1;
        // Multiply $number2 by 2
        $number2 <<= 1;
//        print PHP_EOL;
    }

    return $sum;
}

/**
 * Compute add without using built-in addition
 *
 * @param int $number1
 * @param int $number2
 * @return int
 */
function computeAdditionWithoutAdd($number1, $number2)
{
    $sum = 0;
    $carryIn = 0;
    $k = 1;
    $tempNumber1 = $number1;
    $tempNumber2 = $number2;

    while ($tempNumber1 || $tempNumber2) {
        $number1k = $number1 & $k;
        $number2k = $number2 & $k;
        $carryOut = ($number1k & $number2k) | ($number1k & $carryIn) | ($number2k & $carryIn);
        $sum |= ($number1k ^ $number2k ^ $carryIn);
        $carryIn = $carryOut << 1;
        $k <<= 1;
        $tempNumber1 >>= 1;
        $tempNumber2 >>= 1;
    }

    return $sum | $carryIn;
}

$inputHelper = new InputHelper();
$number1 = $inputHelper->readInputFromStdIn('Enter the first non-negative integer to multiply: ');
$number2 = $inputHelper->readInputFromStdIn('Enter the second non-negative integer to multiply: ');
$result = computeMultiplicationWithoutMultiplyOrAdd((int)$number1, (int)$number2);
printf('The product of %d and %d is %d', $number1, $number2, $result);
print PHP_EOL;
<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) where n is the width of the first number being multiplied
 */

/**
 * Compute multiplication without using built-in multiplication
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

    while ($number1) {
        if ($number1 & 1) {
            $sum = computeAdditionWithoutAdd($sum, $number2);
        }

        $number1 >>= 1;
        $number2 <<= 1;
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
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
 * First bit of 11 is set so sum is increased by 6 (the value of $number2 before it's incremented)
 * $number1 = 1 (1)
 * $number2 = 1100 (12)
 * $sum = 6
 *
 * Iteration 3:
 * First bit of 1 is set so sum is increased by 12 (the value of $number2 before it's incremented)
 * $number1 = 0 (0)
 * $number2 = 11000 (24)
 * $sum = 18
 *
 * @param int $number1
 * @param int $number2
 * @return int
 * @throws \InvalidArgumentException
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

    $sum = 0;

    while ($number1) {
        if ($number1 & 1) {
            $sum = computeAdditionWithoutAdd($sum, $number2);
        }

        $number1 >>= 1;

        // If the sum is already at the max and there is more to go, stop.
        if ($sum >= PHP_INT_MAX && $number1) {
            throw new \RuntimeException('Multiplying these two numbers will overflow');
        }

        // Multiply $number2 by 2 via a left shift
        $number2 <<= 1;
    }

    return $sum;
}

/**
 * Compute add without using built-in addition
 *
 * This works by adding each bit of $number1 and $number2 to $sum and carrying the bit as needed using binary addition.
 * i.e.
 * 110 (6) + 1100 (12)
 *
 * Iteration 1:
 * Bit 1 of 110 is 0 and bit 1 of 1100 is 0 so value is 0 carry 0.
 * $kthBitOfNumber1 = 0
 * $kthBitOfNumber2 = 0
 * $carryOut = 0
 * $sum = 0
 * $carryIn = 0
 * $k = 10 (2)
 *
 * Iteration 2:
 * Bit 2 of 110 is 1 and bit 2 of 1100 is 1 so value is 10 (2) carry 0.
 * $kthBitOfNumber1 = 10 (2)
 * $kthBitOfNumber2 = 00
 * $carryOut = 0
 * $sum = 10 (2)
 * $carryIn = 0
 * $k = 100 (4)
 *
 * Iteration 3:
 * Bit 3 of 110 is 1 and bit 3 of 1100 is 1 so value is 000 carry 1.
 * $kthBitOfNumber1 = 100 (4)
 * $kthBitOfNumber2 = 100 (4)
 * $carryOut = 100 (4)
 * $sum = 010 (4)
 * $carryIn = 1000 (8)
 * $k = 1000 (8)
 *
 * Iteration 4:
 * Bit 4 of 110 is 0 and bit 4 of 1100 is 1 so value is 1000 carry 0.
 * $kthBitOfNumber1 = 0000
 * $kthBitOfNumber2 = 1000
 * $carryOut = 1000 (8)
 * $sum = 0010 (4)
 * $carryIn = 10000 (16)
 * $k = 10000 (16)
 *
 * At this point the loop has terminated however $sum (0010) and $carryIn (10000) are set.  The return value is
 * $sum | $carryIn which is 10010 (18).
 *
 * SUM IS 18
 *
 * @param int $number1
 * @param int $number2
 * @return int
 * @throws RuntimeException
 */
function computeAdditionWithoutAdd($number1, $number2)
{
    $sum = 0;
    $carryIn = 0;
    $k = 1;
    // These temp numbers are only used to determine loop termination
    $tempNumber1 = $number1;
    $tempNumber2 = $number2;

    while ($tempNumber1 || $tempNumber2) {
        // Use a bitmask to get the kth bit of $number1
        $kthBitOfNumber1 = $number1 & $k;
        // Use a bitmask to get the kth bit of $number2
        $kthBitOfNumber2 = $number2 & $k;
        // Should we carry a bit or not?
        // If the kth bit of number1 is 1 and the kth bit of number2 is 0 and carryIn is 0, carry 0.
        // If the kth bit of number1 is 1 and the kth bit of number2 is 1 and carryIn is 0, carry 1.
        // If the kth bit of number1 is 1 and the kth bit of number2 is 0 and carryIn is 1, carry 1.
        // If the kth bit of number1 is 0 and the kth bit of number2 is 1 and carryIn is 1, carry 1.
        $carryOut = ($kthBitOfNumber1 & $kthBitOfNumber2)
            | ($kthBitOfNumber1 & $carryIn)
            | ($kthBitOfNumber2 & $carryIn);
        // Add to the sum.
        // If one of the kth bit of number1, the kth bit of number2 and carryIn is set, toggle the kth bit of sum.
        // If two of the kth bit of number1, the kth bit of number2 and carryIn is set, do not toggle the kth bit of sum.
        // If all of the kth bit of number1, the kth bit of number2 and carryIn are set, toggle the kth bit of sum.
        // This follows the basics of binary addition where 1 + 0 = 1, 1 + 1 = 0 carry the 1 and 1 + 1 + 1 = 1 carry the 1.
        $sum |= ($kthBitOfNumber1 ^ $kthBitOfNumber2 ^ $carryIn);
        // Shift carryOut by 1 so that carryIn is in the proper bit position for the next iteration.
        $carryIn = $carryOut << 1;
        // Shift k by 1 so that it is in the proper bit position for the next iteration.
        $k <<= 1;
        // Shift off the LSB of tempNumber1
        $tempNumber1 >>= 1;
        // Shift off the LSB of tempNumber2
        $tempNumber2 >>= 1;

        // If sum is larger than the maximum int or the sign bit gets toggled
        if ($sum > PHP_INT_MAX || $sum < 0) {
            throw new \RuntimeException('$sum is too large to fit into an integer');
        }
    }

    return $sum | $carryIn;
}

$inputHelper = new InputHelper();
$number1 = $inputHelper->readInputFromStdIn('Enter the first non-negative integer to multiply: ');
$number2 = $inputHelper->readInputFromStdIn('Enter the second non-negative integer to multiply: ');
$result = computeMultiplicationWithoutMultiplyOrAdd((int)$number1, (int)$number2);
printf('The product of %d and %d is %d', $number1, $number2, $result);
print PHP_EOL;
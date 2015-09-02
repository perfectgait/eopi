<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(2^n)
 */

/**
 * Compute x^y using a brute force approach.  This works by multiplying the $base by itself $exponent number of times.
 *
 * @param int $base
 * @param int $exponent
 * @return int|float
 * @throws \InvalidArgumentException
 */
function computeXToTheYBruteForce($base, $exponent)
{
    if (!is_int($base)) {
        throw new \InvalidArgumentException('$base must be an integer');
    }

    if (!is_int($exponent)) {
        throw new \InvalidArgumentException('$exponent must be an integer');
    }

    // Anything to the power of 0 is 1
    $result = 1;

    // Handle negative exponents
    if ($exponent < 0) {
        $base = 1 / $base;
    }

    // Handle out of range exponents
    if ($exponent > PHP_INT_MAX || $exponent < 0) {
        $exponent = PHP_INT_MAX;
    }

    for ($i = 0; $i < $exponent; $i++) {
        $result *= $base;

        if ($result > PHP_INT_MAX) {
            return INF;
        }

        if ((PHP_INT_SIZE == 4 && $result < -2147483648) || (PHP_INT_SIZE == 8 && $result < -9223372036854775808)) {
            return -INF;
        }
    }

    return $result;
}

$inputHelper = new InputHelper();
$base = $inputHelper->readInputFromStdIn('Enter the integer base: ');
$exponent = $inputHelper->readInputFromStdIn('Enter the integer exponent: ');
$result = computeXToTheYBruteForce((int)$base, (int)$exponent);
printf('The value of %d^%d is %f', $base, $exponent, $result);
print PHP_EOL;
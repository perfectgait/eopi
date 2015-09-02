<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) where n is the number of bits needed to represent the $exponent
 */

function computeXToTheYDivideAndConquer($base, $exponent)
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

    while ($exponent) {
        if ($exponent & 1) {
            $result *= $base;
        }

        if ($result > PHP_INT_MAX) {
            return INF;
        }

        if ((PHP_INT_SIZE == 4 && $result < -2147483648) || (PHP_INT_SIZE == 8 && $result < -9223372036854775808)) {
            return -INF;
        }

        $base *= $base;
        $exponent >>= 1;
    }

    return $result;
}

$inputHelper = new InputHelper();
$base = $inputHelper->readInputFromStdIn('Enter the integer base: ');
$exponent = $inputHelper->readInputFromStdIn('Enter the integer exponent: ');
$result = computeXToTheYDivideAndConquer((int)$base, (int)$exponent);
printf('The value of %d^%d is %f', $base, $exponent, $result);
print PHP_EOL;
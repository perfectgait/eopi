<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) where n is the number of bits needed to represent the $exponent
 */

/**
 * Compute x^y using divide and conquer.  The way this works is each iteration the base is raised to the 2^k where k
 * starts at 1.  This lets the algorithm limit the number of multiplications but get the same result.  Consider the
 * concrete example of 3^7.  In the first iteration, 3 is multiplied by 3 which is 3^2.  In the second iteration, 9 is
 * multiplied by 9 which is 3^4.  The remaining 3 multiplications are handled by checking to see if the current bit in
 * the exponent is toggled.  If it is on then a multiplication is performed.  Since 7 is 111 in binary an additional
 * multiplication is performed in each iteration.  This algorithm takes advantage of the property of exponents that
 * lets them be broken apart.  3^7 = 3^(4+3) = 3^4 * 3^3.
 *
 * i.e.
 * 2(10)^5(101)
 *
 * Iteration 1:
 * The LSB of 5(101) is set
 * $result = 2
 * $base = 4
 * $exponent = 2(10)
 *
 * Iteration 2:
 * The LSB of 2(10) is not set
 * $result = 2
 * $base = 16
 * $exponent = 1(1)
 *
 * Iteration 3:
 * The LSB of 1(1) is set
 * $result = 32
 * $base = 256
 * $exponent = 0(0)
 *
 *
 * 3(11)^7(111)
 *
 * 3 (3) x 3 x 3 (27) x 3 x 3 x 3 x 3 (2187)
 *
 * Iteration 1:
 * The LSB of 7(111) is set
 * $result = 3
 * $base = 9
 * $exponent = 3(11)
 *
 * Iteration 2:
 * The LSB of 3(11) is set
 * $result = 27
 * $base = 81
 * $exponent = 1(1)
 *
 * Iteration 3:
 * The LSB of 1(1) is set
 * $result = 2187
 * $base = 6561
 * $exponent = 0(0)
 *
 * @param int $base
 * @param int $exponent
 * @return float|int
 * @throws \InvalidArgumentException
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
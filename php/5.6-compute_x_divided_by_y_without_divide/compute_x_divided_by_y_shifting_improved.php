<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n)
 */

/**
 * Compute $dividend/$divisor using bit shifts to speed up the process.  This is an improvement from the standard
 * shifting script because unlike that method this one starts at the largest value of 2^$power * $divisor and works its
 * way down.  This works by finding the largest value of 2^$power * $divisor that will fit into the dividend.  Once the
 * number is found, 1 << $power is added to the quotient and 2^$power * $divisor is subtracted from the $dividend.
 *
 * @param int $dividend
 * @param int $divisor
 * @return int
 */
function computeXDividedByYShiftingImproved($dividend, $divisor)
{
    if (!is_int($dividend)) {
        throw new \InvalidArgumentException('$dividend must be an integer');
    }

    if ($dividend < 0) {
        throw new \InvalidArgumentException('$dividend must be non-negative');
    }

    if (!is_int($divisor)) {
        throw new \InvalidArgumentException('$divisor must be an integer');
    }

    if ($divisor < 0) {
        throw new \InvalidArgumentException('$divisor must be non-negative');
    }

    if ($divisor == 0) {
        throw new \InvalidArgumentException('Cannot divide by 0');
    }

    $quotient = 0;
    $power = 0;

    // This figures out the maximum power we can raise the divisor by.  This is constant work
    while ($divisor << ($power + 1) < PHP_INT_MAX && $divisor << ($power + 1) > 0) {
        $power++;
    }

    $divisorPower = $divisor << $power;

    while ($dividend >= $divisor) {
        while ($divisorPower > $dividend) {
            $divisorPower >>= 1;
            $power--;
        }

        $quotient += 1 << $power;
        $dividend -= $divisorPower;
    }

    return $quotient;
}

$inputHelper = new InputHelper();
$number1 = $inputHelper->readInputFromStdIn('Enter the non-negative integer dividend: ');
$number2 = $inputHelper->readInputFromStdIn('Enter the non-negative integer divisor: ');
$result = computeXDividedByYShiftingImproved((int)$number1, (int)$number2);
printf('The quotient of %d / %d is %d', $number1, $number2, $result);
print PHP_EOL;
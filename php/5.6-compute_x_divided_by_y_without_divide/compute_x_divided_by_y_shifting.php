<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * If it takes n bits to represent x/y, the time complexity is O(n^2)
 */

/**
 * Compute $dividend/$divisor using bit shifts to speed up the process.  This works by finding the largest value of
 * 2^$power * $divisor that will fit into the $dividend.  Once the number is found, 1 << $power is added to the quotient
 * and 2^$power * $divisor is subtracted from the $dividend.
 * i.e.
 * 1111 (15) / 101 (5)
 *
 * Iteration 1:
 * $power = 1
 * $quotient = 10 (2)
 * $dividend = 101 (5)
 *
 * Iteration 2:
 * $power = 0
 * $quotient = 11 (3)
 * $dividend = 0 (0)
 *
 * @param int $dividend
 * @param int $divisor
 * @return int
 */
function computeXDividedByYShifting($dividend, $divisor)
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

    while ($dividend >= $divisor) {
        $power = 0;

        while ($divisor << ($power + 1) < $dividend) {
            // If the divisor has been shifted so far that the sign bit has changed, stop.  Continuing will result in an
            // infinite loop
            if ($divisor << ($power + 1) < 0) {
                break;
            }

            $power++;
        }

        $quotient += 1 << $power;
        $dividend -= $divisor << $power;
    }

    return $quotient;
}

$inputHelper = new InputHelper();
$number1 = $inputHelper->readInputFromStdIn('Enter the non-negative integer dividend: ');
$number2 = $inputHelper->readInputFromStdIn('Enter the non-negative integer divisor: ');
$result = computeXDividedByYShifting((int)$number1, (int)$number2);
printf('The quotient of %d / %d is %d', $number1, $number2, $result);
print PHP_EOL;
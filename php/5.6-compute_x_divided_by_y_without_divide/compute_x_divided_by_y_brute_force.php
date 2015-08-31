<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) where n is up to 2^63 - 1 (in the case where x= 2^63 and y = 1)
 */

/**
 * Compute x divided by y using brute force.  This works by subtracting y from x until x is less than y.  At that point
 * the number of subtractions performed is the quotient.
 *
 * @param int $dividend
 * @param int $divisor
 * @return int
 * @throws \InvalidArgumentException
 */
function computeXDividedByYBruteForce($dividend, $divisor)
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
        $dividend -= $divisor;
        $quotient++;
    }

    return $quotient;
}

$inputHelper = new InputHelper();
$number1 = $inputHelper->readInputFromStdIn('Enter the non-negative integer dividend: ');
$number2 = $inputHelper->readInputFromStdIn('Enter the non-negative integer divisor: ');
$result = computeXDividedByYBruteForce((int)$number1, (int)$number2);
printf('The quotient of %d / %d is %d', $number1, $number2, $result);
print PHP_EOL;
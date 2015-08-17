<?php

/**
 * The time complexity is O(n)
 */

/**
 * Compute the parity of a number using brute force.  The way this works is by comparing the LSB each bit pass to see
 * if it's toggled using a bitwise and operator.  The result is then compared using the xor bitwise operator.  Then the
 * LSB is shifted off to the right.
 *
 * i.e.
 * 64 = 1000000
 * 1000000 / result = 0
 * 0100000 / result = 0
 * 0010000 / result = 0
 * 0001000 / result = 0
 * 0000100 / result = 0
 * 0000010 / result = 0
 * 0000001 / result = 1
 * parity of 64 is 1
 *
 * 65 = 1000001
 * 1000001 / result = 1
 * 0100000 / result = 1
 * 0010000 / result = 1
 * 0001000 / result = 1
 * 0000100 / result = 1
 * 0000010 / result = 1
 * 0000001 / result = 0
 * parity of 65 is 0
 *
 * @param int $number
 * @return int
 * @throws \InvalidArgumentException
 */
function computeParityBruteForce($number)
{
    if (!is_int($number)) {
        throw new \InvalidArgumentException('$number must be an integer');
    }

    if ($number > PHP_INT_MAX) {
        throw new \InvalidArgumentException('$number must be less than or equal to ' . PHP_INT_MAX);
    }

    if ($number < 0) {
        $number *= -1;
    }

    $result = 0;

    while ($number) {
        $result ^= ($number & 1);
        $number >>= 1;
    }

    return $result;
}

print 'Enter an integer with a value between 0 and ' . PHP_INT_MAX . ': ';
$handle = fopen('php://stdin', 'r');
$number = fgets($handle);
fclose($handle);
$parity = computeParityBruteForce((int) $number);
printf('The parity of %d is %d', $number, $parity);
print PHP_EOL;
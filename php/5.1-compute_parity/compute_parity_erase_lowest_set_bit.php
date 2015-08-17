<?php

/**
 * The time complexity is O(n)
 */

/**
 * Compute the parity of a number using a technique to erase the LSB.
 *
 * i.e.
 * 64 = 1000000
 * 1000000 / result = 1
 * parity of 64 is 1
 * This works because 64 is &'d with 63 = 1000000 is &'d with 0111111.  As we can see that operation will return 0
 * which evaluates to false so the while loop terminates.
 *
 * 65 = 1000001
 * 1000001 / result = 1
 * 1000000 / result = 0
 * parity of 65 is 0
 *
 * This improves performance in the best and average cases but can still be as slow as brute force.  For example if run
 * on 9223372036854775807 it will take 63 iterations which matches brute force.
 *
 * @param int $number
 * @return int
 * @throws \InvalidArgumentException
 */
function computeParityEraseLowestSetBit($number)
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
        $result ^= 1;
        $number &= ($number - 1);
    }

    return $result;
}

print 'Enter an integer with a value less than or equal to ' . PHP_INT_MAX . ': ';
$handle = fopen('php://stdin', 'r');
$number = fgets($handle);
fclose($handle);
$parity = computeParityEraseLowestSetBit((int) $number);
printf('The parity of %d is %d', $number, $parity);
print PHP_EOL;
<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(1)
 */

/**
 * Swap two bits in a number.  This works by first comparing the two bits to be swapped to see if they differ.  If they
 * do not then nothing happens.  If they do differ then a bitmask is created by shifting 1 to the left by i bits,
 * shifting 1 to the left by j bits and or'ing the values.  That bitmask is then xor'd with the original number which
 * flips the bits at the specified indexes.
 *
 * i.e. swap the 1st and 6th bits in 73 (01001001)
 *     00000010 / 1 shifted to the left 1
 * |   01000000 / 1 shifted to the left 6
 * ------------
 *     01000010 / result of or'ing the values
 * ^   01001001 / 73
 * ------------
 *     00001011 / xor'ing the original value with the bitmask results in the 1st and 6th bits being flipped or swapped
 *
 * @param int $number
 * @param int $index1
 * @param int $index2
 * @return int
 */
function swapBits($number, $index1, $index2)
{
    if (!is_int($number) || !is_int($index1) || !is_int($index2)) {
        throw new \InvalidArgumentException('$number, $index1 and $index2 must all be integers');
    }

    if ($index1 < 0 || $index2 < 0) {
        throw new \InvalidArgumentException('$index1 and $index2 must be greater than 0');
    }

    if (PHP_INT_SIZE == 8 && ($index1 > 64 || $index2 > 64)) {
        throw new \InvalidArgumentException('$index1 and $index2 must be less than or equal to 64');
    }

    if (PHP_INT_SIZE == 4 && ($index1 > 32 || $index2 > 32)) {
        throw new \InvalidArgumentException('$index1 and $index2 must be less than or equal to 32');
    }

    // See if the bits differ
    if ((($number >> $index1) & 1) != (($number >> $index2) & 1)) {
        $number ^= (1 << $index1) | (1 << $index2);
    }

    return $number;
}

$inputHelper = new InputHelper();
$number = $inputHelper->readInputFromStdIn('Enter an integer with a value between 0 and ' . PHP_INT_MAX . ': ');
$index1 = $inputHelper->readInputFromStdIn('Enter index 1 in the swap: ');
$index2 = $inputHelper->readInputFromStdIn('Enter index 2 in the swap: ');
$result = swapBits((int) $number, (int) $index1, (int) $index2);
printf('The result of swapping the %d and %d bits of %b is %b', $index1, $index2, $number, $result);
print PHP_EOL;
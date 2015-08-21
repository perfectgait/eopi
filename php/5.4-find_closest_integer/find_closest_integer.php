<?php

require_once '../bootstrap.php';

use EOPI\Helper\BitwiseHelper;
use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) where n is the integer width
 */

/**
 * Find the closest integer with the same weight
 *
 * This works by comparing each bit with the next one starting at the LSB.  When it finds a situation where the 2
 * consecutive bits and different the bits are swapped and the number is returned.
 * i.e.
 * 00000111 (7)
 * The 3rd and 4th bits differ so they are swapped resulting in 00001011 (11)
 *
 * 01010101 (85)
 * The 1st and 2nd bits differ so they are swapped resulting in 01010110 (86)
 *
 * @param int $number
 * @return int
 * @throws \InvalidArgumentException
 * @throws \RuntimeException
 */
function findClosestIntegerWithTheSameWeight($number)
{
    if (!is_int($number)) {
        throw new \InvalidArgumentException('$number must be an integer');
    }

    if ($number < 0) {
        throw new \InvalidArgumentException('$number must be non-negative');
    }

    $integerWidth = PHP_INT_SIZE * BitwiseHelper::WORD_SIZE;

    // Ignore the last bit as it's the sign bit (0 - 62 is 63 bits and 0 - 30 is 31 bits)
    for ($i = 0; $i < $integerWidth - 2; $i++) {
        // If the bits at position i and i + 1 are not the same
        if ((($number >> $i) & 1) ^ (($number >> $i + 1) & 1)) {
            // Swap the bits
            $number ^= (1 << $i) | (1 << ($i + 1));

            return $number;
        }
    }

    throw new \RuntimeException('all bits of $number are 0 or 1');
}


$inputHelper = new InputHelper();
$number = $inputHelper->readInputFromStdIn('Enter a non-negative integer: ');
try {
    $result = findClosestIntegerWithTheSameWeight((int)$number);
    printf('The closest integer to %d (%b) with the same weight is %d (%b)', $number, $number, $result, $result);
    print PHP_EOL;
} catch (\RuntimeException $e) {
    printf('All of the bits in %d (%b) are 0 or 1', $number, $number);
    print PHP_EOL;
}
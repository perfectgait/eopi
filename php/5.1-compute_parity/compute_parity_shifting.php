<?php

require_once '../bootstrap.php';

use EOPI\Helper\BitwiseHelper;
use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(1)
 */

/**
 * Compute the parity of a number by comparing the number to smaller halves of itself over and over.  Because XOR is
 * commutative we can do this until we are down to 4 bits and then use a pre-computed lookup table to compute the final
 * parity.
 * i.e.
 * 64 = 0000000000000000000000000000000000000000000000000000000001000000
 *
 * 0000000000000000000000000000000000000000000000000000000001000000
 * ^                               00000000000000000000000000000000 / Shift 32 bits
 * --------------------------------------------------------------------
 * 0000000000000000000000000000000000000000000000000000000001000000
 * ^               000000000000000000000000000000000000000000000000 / Shift 16 bits
 * --------------------------------------------------------------------
 * 0000000000000000000000000000000000000000000000000000000001000000
 * ^       00000000000000000000000000000000000000000000000000000000 / Shift 8 bits
 * --------------------------------------------------------------------
 * 0000000000000000000000000000000000000000000000000000000001000000
 * ^   000000000000000000000000000000000000000000000000000000000100 / Shift 4 bits
 * --------------------------------------------------------------------
 * 0000000000000000000000000000000000000000000000000000000001000100
 *                                                             0100 / Last 4 bits
 *                 0110100110010110 >> 4 & 1 = 011010011001 & 1 = 1 / Parity
 *
 * 65 = 0000000000000000000000000000000000000000000000000000000001000001
 *
 * 0000000000000000000000000000000000000000000000000000000001000001
 * ^                               00000000000000000000000000000000 / Shift 32 bits
 * --------------------------------------------------------------------
 * 0000000000000000000000000000000000000000000000000000000001000001
 * ^               000000000000000000000000000000000000000000000000 / Shift 16 bits
 * --------------------------------------------------------------------
 * 0000000000000000000000000000000000000000000000000000000001000001
 * ^       00000000000000000000000000000000000000000000000000000000 / Shift 8 bits
 * --------------------------------------------------------------------
 * 0000000000000000000000000000000000000000000000000000000001000001
 * ^   000000000000000000000000000000000000000000000000000000000100 / Shift 4 bits
 * --------------------------------------------------------------------
 * 0000000000000000000000000000000000000000000000000000000001000101
 *                                                             0101 / Last 4 bits
 *                  0110100110010110 >> 5 & 1 = 01101001100 & 1 = 0 / Parity
 *
 * @param $number
 * @return int
 * @throws \InvalidArgumentException
 */
function computeParityShifting($number)
{
    if (!is_int($number)) {
        throw new \InvalidArgumentException('$number must be an integer');
    }

    $bitwiseHelper = new BitwiseHelper();
    $number = $bitwiseHelper->eraseSignBit($number);

    // This contains the parity of 0, 1, 2 ... starting from the LSB
    static $fourBitLookupTable = 0b0110100110010110;

    if (PHP_INT_SIZE == 8) {
        $number ^= $number >> (BitwiseHelper::WORD_SIZE * 4);
    }

    $number ^= $number >> (BitwiseHelper::WORD_SIZE * 2);
    $number ^= $number >> (BitwiseHelper::WORD_SIZE);
    $number ^= $number >> BitwiseHelper::WORD_SIZE / 2;
    $number &= 0b1111;

    return ($fourBitLookupTable >> $number) & 1;
}

$inputHelper = new InputHelper();
$number = $inputHelper->readInputFromStdIn('Enter an integer: ');
$parity = computeParityShifting((int) $number);
printf('The parity of %d is %d', $number, $parity);
print PHP_EOL;
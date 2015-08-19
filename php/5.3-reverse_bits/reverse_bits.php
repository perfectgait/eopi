<?php

require_once '../bootstrap.php';

use EOPI\Helper\BitwiseHelper;
use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(1)
 */

/**
 * Reverse the bits in a number.  This works by first caching the values of all 8-bit words with their bits reversed.
 * Then, using the cached values each 8-bit segment of the number is used to build the number with all bits reversed.
 * The least significant 8-bits of the number are reversed and used as the most significant 8-bits.  Then the next
 * least significant and so on.
 *
 * @param int $number
 * @return int
 */
function reverseBits($number)
{
    if (!is_int($number)) {
        throw new \InvalidArgumentException('$number must be an integer');
    }

    $bitwiseHelper = new BitwiseHelper();
    $number = $bitwiseHelper->eraseSignBit($number);
    $precomputedReverses = getReverseOf8BitWords();
    $bitmask = 0b11111111;

    // 32-bit implementation
    if (PHP_INT_SIZE == 4) {
        return $precomputedReverses[$number & $bitmask] << (3 * BitwiseHelper::WORD_SIZE) |
            $precomputedReverses[($number >> BitwiseHelper::WORD_SIZE) & $bitmask] << (2 * BitwiseHelper::WORD_SIZE) |
            $precomputedReverses[($number >> (2 * BitwiseHelper::WORD_SIZE)) & $bitmask] << BitwiseHelper::WORD_SIZE |
            $precomputedReverses[($number >> (3 * BitwiseHelper::WORD_SIZE)) & $bitmask];
    }

    // 64-bit implementation
    return $precomputedReverses[$number & $bitmask] << (7 * BitwiseHelper::WORD_SIZE) |
        $precomputedReverses[($number >> BitwiseHelper::WORD_SIZE) & $bitmask] << (6 * BitwiseHelper::WORD_SIZE) |
        $precomputedReverses[($number >> (2 * BitwiseHelper::WORD_SIZE)) & $bitmask] << (5 * BitwiseHelper::WORD_SIZE) |
        $precomputedReverses[($number >> (3 * BitwiseHelper::WORD_SIZE)) & $bitmask] << (4 * BitwiseHelper::WORD_SIZE) |
        $precomputedReverses[($number >> (4 * BitwiseHelper::WORD_SIZE)) & $bitmask] << (3 * BitwiseHelper::WORD_SIZE) |
        $precomputedReverses[($number >> (5 * BitwiseHelper::WORD_SIZE)) & $bitmask] << (2 * BitwiseHelper::WORD_SIZE) |
        $precomputedReverses[($number >> (6 * BitwiseHelper::WORD_SIZE)) & $bitmask] << BitwiseHelper::WORD_SIZE |
        $precomputedReverses[($number >> (7 * BitwiseHelper::WORD_SIZE)) & $bitmask];
}

/**
 * Get an array of the pre-computed reverse of all 8-bit words
 *
 * @return array
 */
function getReverseOf8BitWords()
{
    static $cachedReverses = [];

    if (empty($cachedReverses)) {
        if (!file_exists('computed_reverses.txt')) {
            $bitwiseHelper = new BitwiseHelper();
            $cachedReverses = $bitwiseHelper->computeReverseOf8BitWords(0b11111111);
            $fp = fopen('computed_reverses.txt', 'w');
            fwrite($fp, serialize($cachedReverses));
            fclose($fp);
        } else {
            $cachedReverses = unserialize(file_get_contents('computed_reverses.txt'));
        }
    }

    return $cachedReverses;
}

$inputHelper = new InputHelper();
$number = $inputHelper->readInputFromStdIn('Enter an integer: ');
$result = reverseBits((int) $number);
printf('The result of reversing the bits of %b is %b', $number, $result);
print PHP_EOL;
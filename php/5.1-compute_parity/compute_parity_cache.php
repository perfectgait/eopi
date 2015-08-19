<?php

require_once '../bootstrap.php';

use EOPI\Helper\BitwiseHelper;
use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n/L) where n is the number of bits being looked at and L is the width of the words having
 * their parity pre-computed.  Concretely if we cache the parity of all 8-bit words and the number of bits in the
 * number we are checking the parity of is 64 then the time complexity is O(64/8) or O(8).
 */

/**
 * Compute the parity of a number by breaking it into smaller words and xor'ing the parity of each word.  The first
 * step is to cache the parity of all words and then we can use the cached values to speed up the check of the
 * number we want to test.
 * i.e.
 * 64 = 1000000 which is
 * parity[00000000] ^ parity[00000000] ^ parity[00000000] ^ parity[00000000] ^ parity[00000000] ^ parity[00000000] ^ parity[01000000] or
 * 0 ^ 0 ^ 0 ^ 0 ^ 0 ^ 0 ^ 0 ^ 1 = 1
 *
 * @param $number
 * @return int
 * @throws \InvalidArgumentException
 */
function computeParityCache($number)
{
    if (!is_int($number)) {
        throw new \InvalidArgumentException('$number must be an integer');
    }

    $bitwiseHelper = new BitwiseHelper();
    $number = $bitwiseHelper->eraseSignBit($number);
    $precomputedParities = getParityOfWords();
    $bitmask = 0b11111111;

    // 32-bit implementation
    if (PHP_INT_SIZE == 4) {
        return $precomputedParities[$number >> (3 * BitwiseHelper::WORD_SIZE) & $bitmask] ^
            $precomputedParities[$number >> (2 * BitwiseHelper::WORD_SIZE) & $bitmask] ^
            $precomputedParities[$number >> BitwiseHelper::WORD_SIZE & $bitmask] ^
            $precomputedParities[$number & $bitmask];
    }

    // 64-bit implementation
    return $precomputedParities[$number >> (7 * BitwiseHelper::WORD_SIZE) & $bitmask] ^
        $precomputedParities[$number >> (6 * BitwiseHelper::WORD_SIZE) & $bitmask] ^
        $precomputedParities[$number >> (5 * BitwiseHelper::WORD_SIZE) & $bitmask] ^
        $precomputedParities[$number >> (4 * BitwiseHelper::WORD_SIZE) & $bitmask] ^
        $precomputedParities[$number >> (3 * BitwiseHelper::WORD_SIZE) & $bitmask] ^
        $precomputedParities[$number >> (2 * BitwiseHelper::WORD_SIZE) & $bitmask] ^
        $precomputedParities[$number >> BitwiseHelper::WORD_SIZE & $bitmask] ^
        $precomputedParities[$number & $bitmask];
}

/**
 * Get an array of the pre-computed parity of all 8-bit words
 *
 * @return array
 */
function getParityOfWords()
{
    static $cachedParities = [];

    if (empty($cachedParities)) {
        if (!file_exists('computed_parities.txt')) {
            $bitwiseHelper = new BitwiseHelper();
            $cachedParities = $bitwiseHelper->computeParityOfWords(0b11111111);
            $fp = fopen('computed_parities.txt', 'w');
            fwrite($fp, serialize($cachedParities));
            fclose($fp);
        } else {
            $cachedParities = unserialize(file_get_contents('computed_parities.txt'));
        }
    }

    return $cachedParities;
}

$inputHelper = new InputHelper();
$number = $inputHelper->readInputFromStdIn('Enter an integer: ');
$parity = computeParityCache((int) $number);
printf('The parity of %d is %d', $number, $parity);
print PHP_EOL;
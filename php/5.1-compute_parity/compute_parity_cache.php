<?php

/**
 * The time complexity is O(n/L) where n is the number of bits being looked at and L is the width of the words having
 * their parity pre-computed.  Concretely if we cache the parity of all 16-bit words and the number of bits in the
 * number we are checking the parity of is 64 then the time complexity is O(64/16) or O(4).
 */

/**
 * Compute the parity of a number by breaking it into smaller words and comparing the parity of each word.  The first
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

    if ($number > PHP_INT_MAX) {
        throw new \InvalidArgumentException('$number must be less than or equal to ' . PHP_INT_MAX);
    }

    if ($number < 0) {
        $number *= -1;
    }

    $precomputedParities = getParityOfWords();
    $bitmask = pow(2, PHP_INT_SIZE) - 1;

    // PHP_INT_SIZE will either be 8 or 4 for 64-bit or 32-bit implementations respectively.  In either case only 8 bit
    // shifts are necessary as 64 / 8 = 8 and 32 / 4 = 8
    return $precomputedParities[$number >> (7 * PHP_INT_SIZE)] ^
        $precomputedParities[$number >> (6 * PHP_INT_SIZE) & $bitmask] ^
        $precomputedParities[$number >> (5 * PHP_INT_SIZE) & $bitmask] ^
        $precomputedParities[$number >> (4 * PHP_INT_SIZE) & $bitmask] ^
        $precomputedParities[$number >> (3 * PHP_INT_SIZE) & $bitmask] ^
        $precomputedParities[$number >> (2 * PHP_INT_SIZE) & $bitmask] ^
        $precomputedParities[$number >> PHP_INT_SIZE & $bitmask] ^
        $precomputedParities[$number & $bitmask];
}

/**
 * Get an array of the pre-computed parity of all 16-bit words
 *
 * @return array
 */
function getParityOfWords()
{
    static $cachedParities = [];

    if (empty($cachedParities)) {
        if (!file_exists('computed_parities.txt')) {
            for ($i = 0; $i < pow(2, PHP_INT_SIZE); $i++) {
                $cachedParities[$i] = computeParityBruteForce($i);
            }

            $fp = fopen('computed_parities.txt', 'w');
            fwrite($fp, serialize($cachedParities));
            fclose($fp);
        } else {
            $cachedParities = unserialize(file_get_contents('computed_parities.txt'));
        }
    }

    return $cachedParities;
}

/**
 * Compute the parity of a number using brute force.  Only used to pre-compute the parity of words.
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
        throw new \InvalidArgumentException('$number must be less than ' . PHP_INT_MAX);
    }

    if ($number < 0) {
        $number *= -1;
    }

    $result = 0;

    while ($number) {
        $result ^= $number & 1;
        $number >>= 1;
    }

    return $result;
}

print 'Enter an integer with a value less than or equal to ' . PHP_INT_MAX . ': ';
$handle = fopen('php://stdin', 'r');
$number = fgets($handle);
fclose($handle);
$parity = computeParityCache((int) $number);
printf('The parity of %d is %d', $number, $parity);
print PHP_EOL;
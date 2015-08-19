<?php

namespace EOPI\Helper;

/**
 * Class BitwiseHelper
 *
 * @package EOPI\Helper
 */
class BitwiseHelper
{
    const WORD_SIZE = 8;

    /**
     * Compute the parity of a range of words
     *
     * @param int $biggestWord
     * @return array
     * @throw \InvalidArgumentException
     */
    public function computeParityOfWords($biggestWord)
    {
        if (!is_int($biggestWord)) {
            throw new \InvalidArgumentException('$biggestWord must be an integer');
        }

        $parities = [];

        for ($i = 0; $i <= $biggestWord; $i++) {
            $parities[$i] = $this->computeParityBruteForce($i);
        }

        return $parities;
    }

    /**
     * Compute the parity of a number using brute force.  Only used to pre-compute the parity of words.
     *
     * @param int $number
     * @return int
     * @throws \InvalidArgumentException
     */
    private function computeParityBruteForce($number)
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

    /**
     * Erase the sign bit of an integer
     *
     * @param int $number
     * @return int
     * @throw \InvalidArgumentException
     */
    public function eraseSignBit($number)
    {
        if (!is_int($number)) {
            throw new \InvalidArgumentException('$number must be an integer');
        }

        if (PHP_INT_SIZE == 4) {
            return $number & 0b01111111111111111111111111111111;
        }

        return $number & 0b0111111111111111111111111111111111111111111111111111111111111111;
    }

    /**
     * Compute the reverse of all 8-bit words
     *
     * @param int $biggestWord
     * @return array
     * @throw \InvalidArgumentException
     */
    public function computeReverseOf8BitWords($biggestWord)
    {
        if (!is_int($biggestWord)) {
            throw new \InvalidArgumentException('$biggestWord must be an integer');
        }

        $reverses = [];

        for ($i = 0; $i <= $biggestWord; $i++) {
            $reverses[$i] = $this->reverseAllBitsIn8BitNumber($i);
        }

        return $reverses;
    }

    /**
     * Reverse all the bits in an 8-bit number;
     *
     * @param int $number
     * @return int
     * @throw \InvalidArgumentException
     */
    private function reverseAllBitsIn8BitNumber($number)
    {
        if (!is_int($number)) {
            throw new \InvalidArgumentException('$number must be an integer');
        }

        $shifts = 0;
        $bitmask = 0;
        $numberOfBits = self::WORD_SIZE;
        $maxShifts = $numberOfBits / 2;

        while ($shifts < $maxShifts) {
            if ((($number >> $shifts) & 1) != (($number >> $numberOfBits - 1 - $shifts) & 1)) {
                $bitmask |= (1 << $shifts) | (1 << ($numberOfBits - 1 - $shifts));
            }
            $shifts++;
        }

        $number ^= $bitmask;

        return $number;
    }
}
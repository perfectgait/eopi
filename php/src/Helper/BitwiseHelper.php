<?php

namespace EOPI\Helper;

/**
 * Class BitwiseHelper
 *
 * @package EOPI\Helper
 */
class BitwiseHelper
{
    /**
     * Compute the parity of a range of words
     *
     * @param int $biggestWord
     * @return array
     */
    public function computeParityOfWords($biggestWord)
    {
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
}
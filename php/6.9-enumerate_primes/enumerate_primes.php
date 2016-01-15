<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n log log n), the storage complexity is O(n)
 */

/**
 * Enumerate the primes from 1 to n.  This works by not allocating entries for i less than 3, skipping even numbers and
 * starting the sieving process from p^2.  In this function, $isPrime[$i] represents whether or not $i * 2 + 3 is prime.
 * So when $i = 0, $isPrime[$i] determines if the number 3 is prime, which of course it is.  Once $isPrime[$i] is found
 * to be true, the sieving process begins at p^2 which is:
 *
 * = ($i * 2 + 3)^2
 * = (2$i + 3)^2
 * = (2$i + 3)(2$i + 3)
 * = 4$i^2 + 6$i + 6$i + 9
 * = 4$i^2 + 12$i + 9
 *
 * The index for p^2 in $isPrime can be found at:
 *
 * = p^2 - 3 / 2
 * = 4$i^2 + 12$i + 9 - 3 / 2
 * = 4$i^2 + 12$i + 6 / 2
 * = 2$i^2 + 6$i + 3
 *
 * If $i = 0, p = 3 and p^2 is found at index 3.  The number at index 3 is (3 * 2 + 3) = 9.
 *
 * i.e.
 *
 * If $n = 20
 *
 * $kSize = 9
 * $primes = [2]
 * $isPrime = [
 *  0 => true,
 *  1 => true,
 *  2 => true,
 *  3 => true,
 *  4 => true,
 *  5 => true,
 *  6 => true,
 *  7 => true,
 *  8 => true,
 * ]
 *
 * <<< LOOP START >>>
 *
 * Iteration 1:
 * $i = 0
 * Is $isPrime[$i] true? Yes
 * $p = 3
 * $primes = [2, 3]
 *
 * <<< INNER LOOP START >>>
 *
 * Iteration 1:
 * $j = 3
 * $isPrime[3] = false
 *
 * Iteration 2:
 * $j = 6
 * $isPrime[6] = false
 *
 * <<< INNER LOOP TERMINATION: all integers through $kSize have been iterated through >>>
 *
 * $isPrime = [
 *  0 => true,
 *  1 => true,
 *  2 => true,
 *  3 => false,
 *  4 => true,
 *  5 => true,
 *  6 => false,
 *  7 => true,
 *  8 => true,
 * ]
 *
 *
 * Iteration 2:
 * $i = 1
 * Is $isPrime[1] true? Yes
 * $p = 5
 * $primes = [2, 3, 5]
 *
 * <<< INNER LOOP NEVER RUNS: The first iteration $j = 11 which is > $kSize(9) >>>
 *
 * $isPrime = [
 *  0 => true,
 *  1 => true,
 *  2 => true,
 *  3 => false,
 *  4 => true,
 *  5 => true,
 *  6 => false,
 *  7 => true,
 *  8 => true,
 * ]
 *
 *
 * Iteration 3:
 * $i = 2
 * Is $isPrime[2] true? Yes
 * $p = 7
 * $primes = [2, 3, 5, 7]
 *
 * <<< INNER LOOP NEVER RUNS: The first iteration $j = 23 which is > $kSize(9) >>>
 *
 * $isPrime = [
 *  0 => true,
 *  1 => true,
 *  2 => true,
 *  3 => false,
 *  4 => true,
 *  5 => true,
 *  6 => false,
 *  7 => true,
 *  8 => true,
 * ]
 *
 *
 * Iteration 4:
 * $i = 3
 * Is $isPrime[3] true? No
 *
 *
 * Iteration 5:
 * $i = 4
 * Is $isPrime[4] true? Yes
 * $p = 11
 * $primes = [2, 3, 5, 7, 11]
 *
 * <<< INNER LOOP NEVER RUNS: The first iteration $j = 59 which is > $kSize(9) >>>
 *
 * $isPrime = [
 *  0 => true,
 *  1 => true,
 *  2 => true,
 *  3 => false,
 *  4 => true,
 *  5 => true,
 *  6 => false,
 *  7 => true,
 *  8 => true,
 * ]
 *
 *
 * Iteration 6:
 * $i = 5
 * Is $isPrime[5] true? Yes
 * $p = 13
 * $primes = [2, 3, 5, 7, 11, 13]
 *
 * <<< INNER LOOP NEVER RUNS: The first iteration $j = 83 which is > $kSize(9) >>>
 *
 * $isPrime = [
 *  0 => true,
 *  1 => true,
 *  2 => true,
 *  3 => false,
 *  4 => true,
 *  5 => true,
 *  6 => false,
 *  7 => true,
 *  8 => true,
 * ]
 *
 *
 * Iteration 6:
 * $i = 6
 * Is $isPrime[6] true? No
 *
 *
 * Iteration 7:
 * $i = 7
 * Is $isPrime[7] true? Yes
 * $p = 17
 * $primes = [2, 3, 5, 7, 11, 13, 17]
 *
 * <<< INNER LOOP NEVER RUNS: The first iteration $j = 143 which is > $kSize(9) >>>
 *
 * $isPrime = [
 *  0 => true,
 *  1 => true,
 *  2 => true,
 *  3 => false,
 *  4 => true,
 *  5 => true,
 *  6 => false,
 *  7 => true,
 *  8 => true,
 * ]
 *
 *
 * Iteration 8:
 * $i = 8
 * Is $isPrime[8] true? Yes
 * $p = 19
 * $primes = [2, 3, 5, 7, 11, 13, 17, 19]
 *
 * <<< INNER LOOP NEVER RUNS: The first iteration $j = 179 which is > $kSize(9) >>>
 *
 * $isPrime = [
 *  0 => true,
 *  1 => true,
 *  2 => true,
 *  3 => false,
 *  4 => true,
 *  5 => true,
 *  6 => false,
 *  7 => true,
 *  8 => true,
 * ]
 *
 * <<< LOOP TERMINATION: all integers through $kSize have been iterated through >>>
 *
 * $primes = [2, 3, 5, 7, 11, 13, 17, 19]
 *
 * @param int $n
 * @return array
 */
function enumeratePrimes($n)
{
    if (!is_numeric($n) || $n < 2) {
        throw new \InvalidArgumentException('$n must be >= 2');
    }

    $kSize = floor(.5 * ($n - 3)) + 1;
    $primes = [2];
    $isPrime = array_fill(0, $kSize, true);

    for ($i = 0; $i < $kSize; $i++) {
        if ($isPrime[$i]) {
            $p = ($i * 2) + 3;
            $primes[] = $p;

            for ($j = (($i * $i) * 2) + 6 * $i + 3; $j < $kSize; $j += $p) {
                $isPrime[$j] = false;
            }
        }
    }

    return $primes;
}

$inputHelper = new InputHelper();
$n = $inputHelper->readInputFromStdIn('Enter the single positive integer: ');
$result = enumeratePrimes($n);

printf('The primes between 1 and %d are %s', $n, json_encode($result));
print PHP_EOL;
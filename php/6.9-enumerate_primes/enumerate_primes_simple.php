<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n log log n), the storage complexity is O(n)
 */

/**
 * Enumerate the primes from 1 to n.  This works by going through each integer between 2 and $n and looking at the
 * $isPrime flag at that index.  If it is true then that index is added to the $primes array and all multiples of that
 * index are removed from the isPrime array.  This is because all multiples of that index will be divisible by that
 * index so they cannot be prime.
 *
 * i.e.
 *
 * If $n = 5
 *
 * $primes = []
 * $isPrime = [
 *  0 => true,
 *  1 => true,
 *  2 => true,
 *  3 => true,
 *  4 => true,
 *  5 => true
 * ]
 *
 * <<< LOOP START >>>
 *
 * Iteration 1:
 * $i = 2
 * Is $isPrime[2] true? Yes
 * $primes = [2]
 *
 * <<< INNER LOOP RUNS: All multiples of $i(2) are flagged as false in $isPrime >>>
 *
 * $isPrime = [
 *  0 => true,
 *  1 => true,
 *  2 => true,
 *  3 => true,
 *  4 => false,
 *  5 => true
 * ]
 *
 * Iteration 2:
 * $i = 3
 * Is $isPrime[3] true? Yes
 * $primes = [2, 3]
 *
 * <<< INNER LOOP RUNS: All multiples of $i(3) are flagged as false in $isPrime >>>
 *
 * $isPrime = [
 *  0 => true,
 *  1 => true,
 *  2 => true,
 *  3 => true,
 *  4 => false,
 *  5 => true
 * ]
 *
 * Iteration 3:
 * $i = 4
 * Is $isPrime[4] true? No
 * $primes = [2, 3]
 * $isPrime = [
 *  0 => true,
 *  1 => true,
 *  2 => true,
 *  3 => true,
 *  4 => false,
 *  5 => true
 * ]
 *
 * <<< LOOP TERMINATION: all integers through $n have been iterated through >>>
 *
 * $primes = [2, 3]
 *
 * @param int $n
 * @return array
 */
function enumeratePrimes($n)
{
    if (!is_numeric($n) || $n < 2) {
        throw new \InvalidArgumentException('$n must be >= 2');
    }

    $primes = [];
    $isPrime = array_fill(0, $n + 1, true);

    for ($i = 2; $i < $n; $i++) {
        if ($isPrime[$i]) {
            $primes[] = $i;

            for ($j = $i; $j <= $n; $j += $i) {
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
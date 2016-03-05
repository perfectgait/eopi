<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

const PRECISION = 1000;

/**
 * The time complexity is O(n) and the storage complexity is O(n) where n is the length of the numbers array and
 * probabilities array.
 */

/**
 * Compute a non-uniform random number from a set or numbers using given probabilities that each number will occur.
 * This works by first computing a range of all probabilities which correlates to the probability for each number to be
 * chosen.  Then a random number in the set [0, 1000] is generated.  Binary search is used to find the bucket of
 * probabilities that the random number falls in.  The number at that bucket is then returned.
 *
 * i.e.
 * If the input numbers array is [1,4,13,2] and the input probabilities array is [0.4,0.1,0.1,0.4]
 *
 * $ranges = [0]
 *
 * <<< FOREACH LOOP BEGIN >>>
 *
 * Iteration 1:
 * $key = 0
 * $probability = 0.4
 * $ranges = [0, 400]
 *
 * Iteration 2:
 * $key = 1
 * $probability = 0.1
 * $ranges = [0, 400, 500]
 *
 * Iteration 3:
 * $key = 2
 * $probability = 0.1
 * $ranges = [0, 400, 500, 600]
 *
 * Iteration 4:
 * $key = 3
 * $probability = 0.4
 * $ranges = [0, 400, 500, 600, 1000]
 *
 * <<< FOREACH LOOP TERMINATION: Each probability has been processed >>>
 *
 * A random number is generated in the set [0, 1000] and passed to binary search to find the bucket.  The random number
 * in this case is 897 so binary search returns 3.
 *
 * return $numbers[3](2)
 *
 * @param array $numbers
 * @param array $probabilities
 * @return int
 */
function computeNonUniformRandomNumber(array $numbers, array $probabilities)
{
    if (empty($numbers)) {
        throw new \InvalidArgumentException('$numbers may not be empty');
    }

    if (empty($probabilities)) {
        throw new \InvalidArgumentException('$probabilities may not be empty');
    }

    if (count($numbers) != count($probabilities)) {
        throw new \InvalidArgumentException('$numbers and $probabilities must be the same size');
    }

    $ranges = [0];

    foreach ($probabilities as $key => $probability) {
        $ranges[] = $ranges[$key] + ($probability * PRECISION);
    }

    if ($ranges[count($ranges) - 1] != PRECISION) {
        throw new \InvalidArgumentException('$probabilities must add up to 1');
    }

    // PHP Doesn't have a way to generate a random float in the set [0,1] so we use don't use floating point numbers.
    // Of course this only works with percentages that don't contain a higher precision than thousands.  We could make
    // this dynamic but there are also some issues with that when you start dealing with high levels of precision.
    return $numbers[binarySearch($ranges, 0, count($ranges) - 1, mt_rand(0, PRECISION))];
}

/**
 * @param array $numbers
 * @param int $lowIndex
 * @param int $highIndex
 * @param int $valueToFind
 * @return int
 */
function binarySearch(array $numbers, $lowIndex, $highIndex, $valueToFind)
{
    $start = $lowIndex + (int)floor(($highIndex - $lowIndex) / 2);

    if ($valueToFind >= $numbers[$start] && $valueToFind < $numbers[$start + 1]
        || ($start + 1 == count($numbers) - 1 && $valueToFind == $numbers[$start + 1])
    ) {
        return $start;
    }

    if ($valueToFind >= $numbers[$start + 1]) {
        return binarySearch($numbers, $start + 1, $highIndex, $valueToFind);
    } else {
        return binarySearch($numbers, $lowIndex, $start, $valueToFind);
    }
}

$inputHelper = new InputHelper();
$numbers = json_decode($inputHelper->readInputFromStdIn('Enter the array of numbers in json format: '));
$probabilities = json_decode($inputHelper->readInputFromStdIn('Enter the array of probabilities in json format: '));
$result = computeNonUniformRandomNumber($numbers, $probabilities);

printf(
    'A non-uniform random number from the set %s using probabilities %s is %s',
    json_encode($numbers),
    json_encode($probabilities),
    json_encode($result)
);
print PHP_EOL;
<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(lg(end - start + 1)
 */

/**
 * Generate a uniform random number between $start and $end inclusive.  This works by...
 *
 * @param int $start
 * @param int $end
 * @return int
 */
function generateUniformRandomNumber($start, $end)
{
    if (!is_numeric($start) || $start < 0) {
        throw new \InvalidArgumentException('$start must be a number greater than or equal to 0');
    }

    if (!is_numeric($end) || $end < 0) {
        throw new \InvalidArgumentException('$end must be a number greater than or equal to 0');
    }

    if ($start > $end) {
        throw new \InvalidArgumentException('$start must be less than $end');
    }

    $start = (int) $start;
    $end = (int) $end;

    $limit = $end - $start + 1;

    do {
        $result = 0;

        // Make sure that if 1 << $i is less than zero we stop.  Otherwise we will loop forever
        for ($i = 0; ((1 << $i) < $limit) && ((1 << $i) > 0); $i++) {
            $result = ($result * 2) | rand(0, 1);
        }
    } while ($result >= $limit);

    return $result + $start;
}

if (false) {
    $results = [
        1 => 0,
        2 => 0,
        3 => 0,
        4 => 0,
        5 => 0,
    ];
    $tests = 10000;

    for ($i = 0; $i < $tests; $i++) {
        $results[generateUniformRandomNumber(1, 5)]++;
    }

    print 'Tests run: ' . $tests . PHP_EOL;

    foreach ($results as $value => $count) {
        printf('Percentage of %d\'s: %f', $value, ($count / $tests) * 100);
        print PHP_EOL;
    }
} else {
    $inputHelper = new InputHelper();
    $start = $inputHelper->readInputFromStdIn('Enter the start integer: ');
    $end = $inputHelper->readInputFromStdIn('Enter the end integer: ');
    $result = generateUniformRandomNumber($start, $end);

    printf('Random value between %d and %d inclusive: %d', $start, $end, $result);

    print PHP_EOL;
}
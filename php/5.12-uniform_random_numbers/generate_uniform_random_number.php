<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(lg(end - start + 1)
 */

/**
 * Generate a uniform random number between $start and $end inclusive.  This works by appending one more bit to the
 * $result as long as the $result is less than the $range.  Once this finishes the $result is checked to make sure it is
 * not larger than the $range.  If it is the same process continues until a $result is achieved that is less than the
 * $range.  Once that happens the $result is added to the $start and the final result is returned.
 *
 * If the start is 50 and the end is 75:
 * $range = 26
 *
 * Iteration 1a:
 * $i = 0
 * 1 << $i = 1
 * $result = 1 (binary) (chosen randomly)
 *
 * Iteration 2a:
 * $i = 1
 * 1 << $1 = 2
 * $result = 11 (binary) (chosen randomly)
 *
 * Iteration 3a:
 * $i = 2
 * 1 << $i = 4
 * $result = 111 (binary) (chosen randomly)
 *
 * Iteration 4a:
 * $i = 3
 * 1 << $i = 8
 * $result = 1111 (binary) (chosen randomly)
 *
 * Iteration 5a:
 * $i = 4
 * 1 << $i = 16
 * $result = 11111 (binary) (chosen randomly)
 *
 * Iteration 6a:
 * $1 = 5
 * 1 << $i = 32 so execution halts
 *
 * Is 11111 (31) >= 26?  Yes, start over
 *
 * Iteration 1b:
 * $i = 0
 * 1 << $i = 1
 * $result = 0 (binary) (chosen randomly)
 *
 * Iteration 2b:
 * $i = 1
 * 1 << $1 = 2
 * $result = 01 (binary) (chosen randomly)
 *
 * Iteration 3b:
 * $i = 2
 * 1 << $i = 4
 * $result = 010 (binary) (chosen randomly)
 *
 * Iteration 4b:
 * $i = 3
 * 1 << $i = 8
 * $result = 0101 (binary) (chosen randomly)
 *
 * Iteration 5b:
 * $i = 4
 * 1 << $i = 16
 * $result = 01010 (binary) (chosen randomly)
 *
 * Iteration 6b:
 * $1 = 5
 * 1 << $i = 32 so execution halts
 *
 * Is 01010 (10) >= 26?  No, we have a good number
 *
 * return $result (10) + $start (50) = 60
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

    $range = $end - $start + 1;

    do {
        $result = 0;

        // Make sure that if 1 << $i is less than zero we stop.  Otherwise we will loop forever
        for ($i = 0; ((1 << $i) < $range) && ((1 << $i) > 0); $i++) {
            $result = ($result << 1) | rand(0, 1);
        }
    } while ($result >= $range);

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
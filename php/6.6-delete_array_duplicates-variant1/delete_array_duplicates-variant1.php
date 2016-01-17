<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) where n is the length of the input array.
 *
 * The outer loop iterates through $array linearly.  The inner loops run at most n times where n is the length of the
 * input array.
 */

/**
 * Adjust the number of occurrences for elements in an array to be min(2, m) if the number of occurrences of an element
 * is >= the $occurrenceThreshold.  This works by maintaining a write index, boundary and current position in the input
 * array.  At each index, the current value is compared with the boundary item.  If they are different, a sequence has
 * been found and the length of the sequence is measured.
 *
 * If the length is >= the occurrence threshold, A[b] is copied to A[w:w + min(2, $occurrenceThreshold)].  The
 * boundary is then moved to the current index to indicate a new sequence.
 *
 * If the length is < the occurrence threshold, the boundary and write index are moved to the current index.  This case
 * indicates the sequence is left in place.  The boundary is moved to indicate a new sequence.
 *
 *
 * After all iterations, A[i] is compared to A[w].
 *
 * If they are different a new value has been found but the previous sequence has not been measured.  If The length of
 * the sequence is >= the occurrence threshold, A[i] is copied to A[w:w + min(2, $occurrenceThreshold)].
 *
 * If they are different and the length of the sequence is < the occurrence threshold, A[i] is copied to A[w].
 *
 * If they are not different, w is incremented by one so array_slice returns the proper value.
 *
 * i.e.
 *
 * If the input array is [1, 1, 1, 2, 2, 2] and $occurrenceThreshold = 3
 *
 * $array = [1, 1, 1, 2, 2, 2]
 * $writeIndex = 0
 * $boundary = 0
 *
 * <<< LOOP START >>>
 *
 * Iteration 1:
 * $i = 1
 * Is $array[$i(1)] != $array[$boundary(0)]? No
 *
 * Iteration 2:
 * $i = 2
 * Is $array[$i(2)] != $array[$boundary(0)]? No
 *
 * Iteration 3:
 * $i = 3
 * Is $array[$i(3)] != $array[$boundary(0)]? Yes
 * Is $i(3) - $boundary(0) = 3 >= $occurrenceThreshold(3)? Yes
 * $array = [1, 1, 1, 2, 2, 2]
 * $writeIndex = 2
 * $boundary = 3
 *
 * Iteration 4:
 * $i = 4
 * Is $array[$i(4)] != $array[$boundary(3)]? No
 *
 * Iteration 5:
 * $i = 5
 * Is $array[$i(5)] != $array[$boundary(3)]? No
 *
 * <<< LOOP TERMINATION: $i == count($array) >>>
 *
 * $i = 6
 * Is $array[$i - 1(5)] != $array[$writeindex(2)]? Yes
 * Is $i(6) - $boundary(3) >= $occurrenceThreshold(3)? Yes
 * $array = [1, 1, 2, 2, 2, 2]
 * $writeIndex = 4
 *
 * array_slice($array, 0, $writeIndex(4)) = [1, 1, 2, 2]
 *
 * ========================================================
 *
 * If the input array is [1, 1, 1, 2, 2, 2, 3] and $occurrenceThreshold = 3
 *
 * $array = [1, 1, 1, 2, 2, 2, 3]
 * $writeIndex = 0
 * $boundary = 0
 *
 * <<< LOOP START >>>
 *
 * Iteration 1:
 * $i = 1
 * Is $array[$i(1)] != $array[$boundary(0)]? No
 *
 * Iteration 2:
 * $i = 2
 * Is $array[$i(2)] != $array[$boundary(0)]? No
 *
 * Iteration 3:
 * $i = 3
 * Is $array[$i(3)] != $array[$boundary(0)]? Yes
 * Is $i(3) - $boundary(0) = 3 >= $occurrenceThreshold(3)? Yes
 * $array = [1, 1, 1, 2, 2, 2, 3]
 * $writeIndex = 2
 * $boundary = 3
 *
 * Iteration 4:
 * $i = 4
 * Is $array[$i(4)] != $array[$boundary(3)]? No
 *
 * Iteration 5:
 * $i = 5
 * Is $array[$i(5)] != $array[$boundary(3)]? No
 *
 * Iteration 6:
 * $i = 6
 * Is $array[$i(6)] != $array[$boundary(3)]? Yes
 * Is $i(6) - $boundary(3) = 3 >= $occurrenceThreshold(3)? Yes
 * $array = [1, 1, 2, 2, 2, 2, 3]
 * $writeIndex = 4
 * $boundary = 6
 *
 * <<< LOOP TERMINATION: $i == count($array) >>>
 *
 * $i = 7
 * Is $array[$i - 1(6)] != $array[$writeindex(4)]? Yes
 * Is $i(7) - $boundary(6) >= $occurrenceThreshold(3)? No
 * $array = [1, 1, 2, 2, 3, 2, 3]
 * $writeIndex = 5
 *
 * array_slice($array, 0, $writeIndex(5)) = [1, 1, 2, 2, 3]
 *
 * ========================================================
 *
 * If the input array is [1, 2, 3, 4, 5] and $occurrenceThreshold = 3
 *
 * $array = [1, 2, 3, 4, 5]
 * $writeIndex = 0
 * $boundary = 0
 *
 * <<< LOOP START >>>
 *
 * Iteration 1:
 * $i = 1
 * Is $array[$i(1)] != $array[$boundary(0)]? Yes
 * Is $i(1) - $boundary(0) = 1 >= $occurrenceThreshold(3)? No
 * $boundary = 1
 * $writeIndex = 1
 *
 * Iteration 2:
 * $i = 2
 * Is $array[$i(2)] != $array[$boundary(1)]? Yes
 * Is $i(2) - $boundary(1) = 1 >= $occurrenceThreshold(3)? No
 * $boundary = 2
 * $writeIndex = 2
 *
 * Iteration 3:
 * $i = 3
 * Is $array[$i(3)] != $array[$boundary(2)]? Yes
 * Is $i(3) - $boundary(2) = 1 >= $occurrenceThreshold(3)? No
 * $boundary = 3
 * $writeIndex = 3
 *
 * Iteration 4:
 * $i = 4
 * Is $array[$i(4)] != $array[$boundary(3)]? Yes
 * Is $i(4) - $boundary(3) = 1 >= $occurrenceThreshold(3)? No
 * $boundary = 4
 * $writeIndex = 4
 *
 * <<< LOOP TERMINATION: $i == count($array) >>>
 *
 * $i = 5
 * Is $array[$i - 1(4)] != $array[$writeindex(4)]? No
 * $writeIndex = 5
 *
 * array_slice($array, 0, $writeIndex(5)) = [1, 2, 3, 4, 5]
 *
 * @param array $array
 * @param int $occurrenceThreshold
 * @return array
 * @throws \InvalidArgumentException
 */
function adjustOccurrences($array, $occurrenceThreshold)
{
    if (!is_numeric($occurrenceThreshold) || $occurrenceThreshold < 1) {
        throw new \InvalidArgumentException('$occurrences must be a positive integer');
    }

    if (count($array) === 1) {
        return $array;
    }

    $writeIndex = 0;
    $boundary = 0;

    for ($i = 1; $i < count($array); $i++) {
        if ($array[$i] != $array[$boundary] && $i - $boundary >= $occurrenceThreshold) {
            for ($j = 0; $j < min(2, $occurrenceThreshold); $j++) {
                $array[$writeIndex++] = $array[$boundary];
            }

            $boundary = $i;
        } elseif ($array[$i] != $array[$boundary] && $i - $boundary < $occurrenceThreshold) {
            $boundary = $i;
            $writeIndex = $i;
        }
    }

    if ($array[$i - 1] != $array[$writeIndex] && $i - $boundary >= $occurrenceThreshold) {
        for ($j = 0; $j < min(2, $occurrenceThreshold); $j++) {
            $array[$writeIndex++] = $array[$i - 1];
        }
    } elseif ($array[$i - 1] != $array[$writeIndex] && $i - $boundary < $occurrenceThreshold) {
        $array[$writeIndex++] = $array[$i - 1];
    } else {
        $writeIndex = $i;
    }

    return array_slice($array, 0, $writeIndex);
}

$inputHelper = new InputHelper();
$array = json_decode($inputHelper->readInputFromStdIn('Enter the sorted array of integers in json format: '));
$occurrenceThreshold = $inputHelper->readInputFromStdIn('Enter the occurrence threshold for an element to appear exactly min(2, m) times: ');
$result = adjustOccurrences($array, $occurrenceThreshold);

printf('The value of %s after ensuring that any element which occurs at least %d times occurs exactly %d times is %s', json_encode($array), $occurrenceThreshold, min(2, $occurrenceThreshold), json_encode($result));
print PHP_EOL;
<?php

/**
 * Merge several sorted arrays representing file data.
 *
 * The time complexity of <method> is O(n log k)
 */

/**
 * Merge an array of arrays so that the result is in sorted order.
 *
 * @param array $arrays
 * @return array
 */
function mergeSortedArrays(array $arrays)
{
    if (empty($arrays)) {
        return [];
    }

    $heads = array_fill(0, count($arrays), 0);
    $minHeap = new \SplMinHeap();
    $result = [];

    // Insert the first value from each sorted array into the min heap
    for ($i = 0; $i < count($arrays); $i++) {
        if (!empty($arrays[$i])) {
            $minHeap->insert([$arrays[$i][0], $i]);
            $heads[$i] = 1;
        }
    }

    while (!$minHeap->isEmpty()) {
        $smallestArray = $arrays[$minHeap->top()[1]];
        $smallestHead = $heads[$minHeap->top()[1]];
        $result[] = $minHeap->top()[0];

        // If the smallest array has more values, put the next one into the heap
        if ($smallestHead < count($smallestArray)) {
            $minHeap->insert([$smallestArray[$smallestHead], $minHeap->top()[1]]);
            $heads[$minHeap->top()[1]] += 1;
        }

        $minHeap->extract();
    }

    return $result;
}

$array1 = [1, 10, 20, 30];
$array2 = [1, 5, 10, 15];
$array3 = [2, 4, 8, 16];
$array4 = [3, 9, 27, 81];
$result = mergeSortedArrays([
    $array1,
    $array2,
    $array3,
    $array4,
]);

$result2 = mergeSortedArrays([]);

var_dump($result);
var_dump($result2);

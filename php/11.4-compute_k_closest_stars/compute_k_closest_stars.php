<?php

require_once '../bootstrap.php';

use EOPI\DataStructures\ObjectMaxHeap;
use EOPI\Helper\InputHelper;
use EOPI\Star;

/**
 * The time complexity is O(n log k) where n is the length of the input file and the space complexity is O(k).
 */

/**
 * Compute the first k closest (to Earth) stars.  This works by reading each line of the input file containing the star
 * coordinates.  For each non-blank line read, a new star is created.  The new star is then inserted into a max heap.
 * If the max heap contains more than k elements, the top element is extracted, ensuring there are only k elements in
 * the max heap.  This continues for every line of the input file.  At the end, all of the elements are extracted from
 * the max heap and placed into the return array and the array is returned.  The max heap data structure ensures that
 * the first k closest stars are always kept.
 *
 * Providing an example of how this works seems beyond the scope of this file.  For a clearer understanding, read about
 * how a max/min heap works.
 *
 * @param int $k
 * @param string $filePath
 * @return array
 */
function computeKClosestStars($k, $filePath)
{
    $fp = fopen($filePath, 'r');
    $results = [];
    $maxHeap = new ObjectMaxHeap();

    while (!feof($fp)) {
        $line = fgetcsv($fp);

        // Ignore blank lines
        if ($line) {
            $star = new Star($line[0], $line[1], $line[2]);
            $maxHeap->insert($star);

            if ($maxHeap->count() > $k) {
                $maxHeap->extract();
            }
        }
    }

    fclose($fp);

    while (!$maxHeap->isEmpty()) {
        $results[] = $maxHeap->extract();
    }

    return $results;
}

$inputHelper = new InputHelper();
$k = $inputHelper->readInputFromStdIn('Enter the number of stars to find: ');
$kClosestStars = computeKClosestStars($k, './stars.txt');

print 'The first ' . $k . ' closest stars are: ' . PHP_EOL;

foreach (array_reverse($kClosestStars) as $star) {
    print $star . PHP_EOL;
}

<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) and the space complexity is O(1)
 */

/**
 * Find the k-th largest element in an array.  This works by first creating a boundary using $left and $right.  The
 * boundary is set to 0 and count($input) - 1 to start.  Then the method iterates while the left boundary is <= the
 * right boundary.  At each iteration, a random value is chosen between $left and $right (inclusive).  That random value
 * along with the left and right values are then passed to the partition function which partitions the array into 3
 * sections.  Values less than the value at the pivot index, the value at the pivot index and values greater than the
 * pivot index.
 * If the returned partition index is equal to $k - 1 (everything we do is 0 based), the k-th largest
 * element has been found.  We know this because there are exactly $k - 1 elements in the array before the partition
 * index if the partition index is equal to $k - 1.
 * If the returned partition index is greater than $k - 1, the k-th largest element must be in the left side of the
 * partitioned array.  We know this because there are at least $k elements in the left side of the partitioned array if
 * the partition index is greater than $k - 1.  In this case, the right boundary is set to the partition index - 1 and
 * the loop continues.
 * If the returned partition index is not equal to or greater than $k - 1, the k-th largest element must be in the right
 * side of the partitioned array.  We know this because there are fewer than $k elements in the left side of the
 * partitioned array if the index is less than $k - 1.  In this case, the left boundary is set to the partition index
 * + 1 and the loop continues.
 *
 * i.e.
 * If the input array is [3, 2, 1, 5, 4] and $k is 3
 *
 * $left = 0
 * $right = 4
 *
 * <<< WHILE LOOP BEGIN >>>
 *
 * Iteration 1:
 * $pivotIndex = 2 (random value chosen between 0 and 4)
 * $partitionIndex = 0
 * $input = [1, 2, 3, 4, 5] (after being modified in partitionAroundPivot())
 * Is $partitionIndex(0) === $k - 1(2)? No
 * Is $partitionIndex(0) > $k - 1(2)? No
 * $left = 1
 *
 * Iteration 2:
 * $pivotIndex = 3 (random value chosen between 1 and 4)
 * $partitionIndex = 4
 * $input = [1, 2, 3, 4, 5] (after being modified in partitionAroundPivot())
 * Is $partitionIndex(4) === $k - 1(2)? No
 * Is $partitionIndex(4) > $k - 1(2)? Yes
 * $right = 3
 *
 * Iteration 3:
 * $pivotIndex = 2 (random value chosen between 1 and 3
 * $partitionIndex = 2
 * $input = [1, 2, 3, 4, 5] (after being modified in partitionAroundPivot())
 * Is $partitionIndex(2) === $k - 1(2)? Yes
 * return $input[2](3)
 *
 * <<< WHILE LOOP TERMINATION: return >>>
 *
 * @param array $input
 * @param int $k
 * @return int
 */
function findKthLargestElement(array $input, $k)
{
    if (empty($input)) {
        throw new \InvalidArgumentException('The input array must not be empty');
    }

    $left = 0;
    $right = count($input) - 1;

    while ($left <= $right) {
        $pivotIndex = rand($left, $right);
        $partitionIndex = partitionAroundPivot($input, $left, $right, $pivotIndex);

        if ($partitionIndex === $k - 1) {
            return $input[$partitionIndex];
        } elseif ($partitionIndex > $k - 1) {
            $right = $partitionIndex - 1;
        } else {
            $left = $partitionIndex + 1;
        }
    }
}

/**
 * Partition an array around a pivot such that all elements less than the pivot element come first, then the pivot
 * element, then elements greater than the pivot element.  This works by first swapping the element at the pivot index
 * with the element at the left index.  Then it iterates from left to right, starting at the left index + 1 and going to
 * the right index.  At each iteration the value at $input[$i] is compared to the pivot value.  If the value is less
 * than the pivot value, the current value is swapped with the value at the write index and the write index is increased
 * by 1.  At the end of all iterations, the value at the left index is swapped with the value at write index - 1.  This
 * moves the pivot element back into place.
 *
 * i.e.
 * If the input array is [3, 2, 1, 5, 4], $left is 0, $right is 4 and the $pivotIndex is 4
 *
 * $temp = 3
 * $pivotElement = 4
 * $input = [4, 2, 1, 5, 3] after swapping
 * $writeIndex = 1
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * Iteration 1:
 * $i = 1
 * $temp = 2
 * Is 2 < 4? Yes
 * $input = [4, 2, 1, 5, 3] after swapping
 * $writeIndex = 2
 *
 * Iteration 2:
 * $i = 2
 * $temp = 1
 * Is 1 < 4? Yes
 * $input = [4, 2, 1, 5, 3] after swapping
 * $writeIndex = 3
 *
 * Iteration 3:
 * $i = 3
 * $temp = 5
 * Is 5 < 4? No
 *
 * Iteration 4:
 * $i = 4
 * $temp = 3
 * Is 3 < 4? Yes
 * $input = [4, 2, 1, 3, 5] after swapping
 * $writeIndex = 4
 *
 * <<< FOR LOOP TERMINATION: $i = 5 >>>
 *
 * $input = [3, 2, 1, 4, 5] after swapping
 *
 * return 3
 *
 * @param array $input
 * @param int $left
 * @param int $right
 * @param int $pivotIndex
 * @return int
 */
function partitionAroundPivot(array &$input, $left, $right, $pivotIndex)
{
    $temp = $input[$left];
    $pivotElement = $input[$pivotIndex];
    $input[$left] = $pivotElement;
    $input[$pivotIndex] = $temp;
    $writeIndex = $left + 1;

    for ($i = $left + 1; $i <= $right; $i++) {
        $temp = $input[$i];

        if ($input[$i] < $pivotElement) {
            $input[$i] = $input[$writeIndex];
            $input[$writeIndex++] = $temp;
        }
    }

    $input[$left] = $input[$writeIndex - 1];
    $input[$writeIndex - 1] = $pivotElement;

    return $writeIndex - 1;
}

$inputHelper = new InputHelper();
$input = json_decode($inputHelper->readInputFromStdIn('Enter the json encoded array of distinct integers: '));
$k = $inputHelper->readInputFromStdIn('Enter the number of the item to find: ');
$result = findKthLargestElement($input, $k);

printf('The %d(th|nd|st) largest element in %s is: %d.', $k, json_encode($input), $result);
print PHP_EOL;
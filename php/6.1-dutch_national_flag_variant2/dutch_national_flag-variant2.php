<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(1) and this uses O(1) more space that the original problem to store the left key
 */

/**
 * ...
 *
 * @param int $index
 * @param array $array
 * @return array
 */
function dutchNationalFlagPartitionVariant1($index, $array)
{
    if (!isset($array[$index])) {
        throw new \OutOfBoundsException('The $index does not exist in the $array');
    }

    $pivot = $array[$index]->key;
    $leftKey = null;
    $left = 0;
    $middle = 0;
    $right = count($array) - 1;

    while ($middle <= $right) {
        if ($array[$middle]->key == $pivot) {
            $middle++;
        } elseif (empty($leftKey) || $array[$middle]->key == $leftKey) {
            if (empty($leftKey)) {
                $leftKey = $array[$middle]->key;
            }

            swapElements($array, $left++, $middle++);
        } else {
            swapElements($array, $middle, $right--);
        }
    }

    return $array;
}

/**
 * Swap elements in an array
 *
 * @param array $array
 * @param int $index1
 * @param int $index2
 */
function swapElements(&$array, $index1, $index2)
{
    $firstElement = $array[$index1];
    $array[$index1] = $array[$index2];
    $array[$index2] = $firstElement;
}

$inputHelper = new InputHelper();
$array = json_decode($inputHelper->readInputFromStdIn('Enter the array of objects in json format: '));
$index = $inputHelper->readInputFromStdIn('Enter the index to use as the pivot: ');
$result = dutchNationalFlagPartitionVariant1($index, $array);

printf('Partitioning the array %s results in %s.', json_encode($array), json_encode($result));
print PHP_EOL;
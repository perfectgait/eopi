<?php

/**
 * The time complexity of merge_sorted_lists is O(n + m) where n and m are the lengths of the linked lists
 */

/**
 * Merge two already sorted linked lists into one sorted linked list
 *
 * @param SplDoublyLinkedList $list1
 * @param SplDoublyLinkedList $list2
 * @return SplDoublyLinkedList
 */
function merge_sorted_lists(\SplDoublyLinkedList $list1, \SplDoublyLinkedList $list2)
{
    // If list 1 is empty, list 2 is all we need
    if ($list1->isEmpty()) {
        return $list2;
    }

    // If list 2 is empty, list 1 is all we need
    if ($list2->isEmpty()) {
        return $list1;
    }

    $newList = new \SplDoublyLinkedList();
    $list1->rewind();
    $list2->rewind();

    // Go through each list picking the smallest of the two items each time
    while ($list1->valid() && $list2->valid()) {
        if ($list1->current() <= $list2->current()) {
            $newList->push($list1->current());
            $list1->next();
        } else {
            $newList->push($list2->current());
            $list2->next();
        }
    }

    // If list 1 still has more items, add them all
    if ($list1->valid()) {
        while ($list1->valid()) {
            $newList->push($list1->current());
            $list1->next();
        }
    }

    // If list 2 still has more items, add them all
    if ($list2->valid()) {
        while ($list2->valid()) {
            $newList->push($list2->current());
            $list2->next();
        }
    }

    return $newList;
}


$list1 = new \SplDoublyLinkedList();
$list1->push(1);
$list1->push(3);
$list1->push(5);
$list1->push(7);
$list1->push(9);

$list2 = new \SplDoublyLinkedList();
$list2->push(2);
$list2->push(4);
$list2->push(6);
$list2->push(8);
$list2->push(10);

$list3 = new \SplDoublyLinkedList();
$list3->push(2);
$list3->push(2);
$list3->push(2);

$list4 = new \SplDoublyLinkedList();
$list4->push(1);
$list4->push(1);
$list4->push(1);

var_dump(merge_sorted_lists($list1, $list2));
var_dump(merge_sorted_lists($list3, $list4));
var_dump(merge_sorted_lists($list1, new \SplDoublyLinkedList()));
var_dump(merge_sorted_lists(new \SplDoublyLinkedList(), $list2));
var_dump(merge_sorted_lists(new \SplDoublyLinkedList(), new \SplDoublyLinkedList()));
<?php

require_once '../bootstrap.php';

use \EOPI\DataStructures\ListNode;
use \EOPI\DataStructures\SinglyLinkedList;
use \EOPI\Factory\NodeFactory;
use \EOPI\Helper\InputHelper;

/**
 * The time complexity is O(n) and the space complexity is O(1)
 */

/**
 * Reverse a singly linked list in place.  This works by first setting the current node to the head node.  It then sets
 * the current nodes next pointer to the previous value, sets previous to current and current to next.  This is pretty
 * straightforward however the order in which things are done is important.  i.e. failure to set next to current->next
 * before updating current->next will cause failures.
 *
 * i.e.
 * If the $head is 4 and the list overall is 4->3->2->1
 *
 * $previous = null
 * $current = 4
 *
 * <<< WHILE LOOP BEGIN >>>
 *
 * Iteration 1:
 * $next = 3
 * $current->next = null
 * $previous = 4
 * $current = 3
 * Result: null<-4 3->2->1->null
 *
 * Iteration 2:
 * $next = 2
 * $current->next = 4
 * $previous = 3
 * $current = 2
 * Result: null<-4<-3 2->1->null
 *
 * Iteration 3:
 * $next = 1
 * $current->next = 3
 * $previous = 2
 * $current = 1
 * Result: null<-4<-3<-2 1->null
 *
 * Iteration 4:
 * $next = null
 * $current->next = 2
 * $previous = 1
 * $current = null
 * Result: null<-4<-3<-2<-1
 *
 * <<< WHILE LOOP TERMINATION: $current is null >>>
 *
 * Final Result: null<-4<-3<-2<-1
 *
 * @param ListNode $head
 * @return ListNode
 */
function reverseLinkedList(ListNode &$head)
{
    $previous = null;
    $current = $head;

    while ($current) {
        $next = $current->next;
        $current->next = $previous;
        $previous = $current;
        $current = $next;
    }

    return $previous;
}

$nodeFactory = new NodeFactory();
$inputHelper = new InputHelper();
$integers = json_decode($inputHelper->readInputFromStdIn('Enter the list of integers in ascending order as a json encoded array: '));
$list = new SinglyLinkedList();
$previousNode = null;

foreach ($integers as $integer) {
    $node = NodeFactory::makeListNode($integer, $previousNode);

    if (is_null($previousNode)) {
        $list->insertFront($node);
    } else {
        $list->insertAfter($node, $previousNode);
    }

    $previousNode = $node;
}

$newHead = reverseLinkedList($list->head);
$newIntegers = [];

while ($newHead) {
    $newIntegers[] = $newHead->value;
    $newHead = $newHead->next;
}

printf('The original list %s was converted to %s', json_encode($integers), json_encode($newIntegers));
print PHP_EOL;
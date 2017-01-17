<?php

namespace EOPI\Factory;

use EOPI\DataStructures\ListNode;
use EOPI\DataStructures\SinglyLinkedList;

/**
 * Class LinkedListFactory
 */
class LinkedListFactory
{
    /**
     * @param array $values
     * @return SinglyLinkedList
     */
    public static function makeSinglyLinkedListFromArray($values = [])
    {
        if (empty($values)) {
            throw new \InvalidArgumentException('$values cannot be empty');
        }

        $linkedList = new SinglyLinkedList();
        $previousNode = null;

        foreach ($values as $value) {
            $node = $value instanceof ListNode ? $value : NodeFactory::makeListNode($value);

            if (is_null($previousNode)) {
                $linkedList->insertFront($node);
            } else {
                $linkedList->insertAfter($node, $previousNode);
            }

            $previousNode = $node;
        }

        return $linkedList;
    }

    /**
     * @param ListNode $head
     * @return SinglyLinkedList
     */
    public static function makeSinglyLinkedListFromHead(ListNode $head)
    {
        $linkedList = new SinglyLinkedList();
        $linkedList->head = $head;

        return $linkedList;
    }
}
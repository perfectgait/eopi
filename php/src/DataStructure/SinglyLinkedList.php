<?php

namespace EOPI\DataStructure;

use EOPI\ListNode;

/**
 * Class SinglyLinkedList
 *
 * This class has been created on a as needed bases.  i.e. only the methods needed at the current time were implemented.
 */
class SinglyLinkedList
{
    /**
     * @var ListNode|null
     */
    public $head;

    /**
     * SinglyLinkedList constructor.
     */
    public function __construct()
    {
        $this->head = null;
    }

    /**
     * @param ListNode $node
     */
    public function insertFront(ListNode $node)
    {
        $node->next = $this->head;
        $this->head = $node;
    }

    /**
     * @param ListNode $newNode
     * @param ListNode $afterNode
     */
    public function insertAfter(ListNode $newNode, ListNode $afterNode)
    {
        $newNode->next = $afterNode->next;
        $afterNode->next = $newNode;
    }
}
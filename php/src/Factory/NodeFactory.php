<?php

namespace EOPI\Factory;

use EOPI\Node;
use EOPI\DataStructures\ListNode;

/**
 * Class NodeFactory
 */
class NodeFactory
{
    /**
     * @param mixed $key
     * @param Node|null $parent
     * @return Node
     */
    public static function makeNode($key, Node $parent = null)
    {
        $node = new Node();
        $node->key = $key;
        $node->parent = $parent;

        return $node;
    }

    /**
     * @param mixed $value
     * @param ListNode|null $next
     * @return ListNode
     */
    public static function makeListNode($value, ListNode $next = null)
    {
        $node = new ListNode();
        $node->value = $value;
        $node->next = $next;

        return $node;
    }
}
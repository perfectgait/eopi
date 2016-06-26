<?php

namespace EOPI\Factory;

use EOPI\Node;

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
}
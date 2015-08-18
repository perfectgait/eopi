<?php

/**
 * Node in a binary tree
 */

namespace BinaryTree;

/**
 * Class Node
 */
class Node
{
    /**
     * @var Node|null
     */
    public $parent;

    /**
     * @var Node|null
     */
    public $left;

    /**
     * @var Node|null
     */
    public $right;

    /**
     * @var mixed
     */
    public $key;
}
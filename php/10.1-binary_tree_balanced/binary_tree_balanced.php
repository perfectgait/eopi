<?php

/**
 * Check to see if a binary tree is balanced.  The way it works is by doing a post-order traversal and checking each
 * sub-tree for balance and then the root for balance.  If either sub-tree is not balanced the result is returned
 * immediately.
 *
 * The space bound of checkBalanced is O(h)
 * The time complexity of checkBalanced is O(n)
 */

require_once '../lib/BinaryTree.php';
require_once '../lib/Node.php';

use BinaryTree\Node;

/**
 * Check to see if the node in a binary tree is balanced.  That is, is the difference in height of each nodes left and
 * right sub-trees at most 1?
 *
 * @param Node $node
 * @return array
 */
function checkBalanced(Node $node)
{
    // Base case
    if ($node == null) {
        return [true, -1];
    }

    $leftResult = checkBalanced($node->left);

    // The left sub-tree is not balanced
    if (!$leftResult[0]) {
        return [false, 0];
    }

    $rightResult = checkBalanced($node->right);

    // The right sub-tree is not balanced
    if (!$rightResult[0]) {
        return [false, 0];
    }

    $isBalanced = abs($leftResult[1] - $rightResult[1]) <= 1;
    $height = max($leftResult[1], $rightResult[1]) + 1;

    return [$isBalanced, $height];
}
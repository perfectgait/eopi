<?php

require_once '../bootstrap.php';

use \EOPI\DataStructure\BinarySearchTree;
use \EOPI\Factory\NodeFactory;

/**
 * The time complexity is O(h) where h is the height of the BST and the space complexity is O(1)
 */

/**
 * This works by iterating through nodes in the BST and at each iteration, comparing the node's value to the value being
 * searched.
 * If the node's value is greater than the value being searched, the best found value is updated to the
 * node's value.  Then the left subtree of the current node is searched because going to the right would produce a value
 * larger than the one that was just found.
 * If the node's value is less than or equal to the value being searched, the best found value is not updated because we
 * only want the closest value which is greater.  Then the right subtree of the current node is searched because going
 * to the left would produce an even smaller value than the one that was just found.
 * Once the leaf node is hit, the iterator finishes and the closest value that is greater than the search value is
 * found (if it exists).
 *
 * i.e.
 * If the input tree is:
 *                           8
 *                         /   \
 *                        3    10
 *                       / \    \
 *                      1   6   14
 *
 * And the search value is 8
 *
 * $node = 8
 * $bestFound = null
 *
 * <<< WHILE LOOP BEGIN >>>
 *
 * Iteration 1:
 * $node = 8
 * Is 8 > 8? No
 * $node = 10
 *
 * Iteration 2:
 * $node = 10
 * Is 10 > 8? Yes
 * $bestFound = 10
 * $node = null
 *
 * <<< WHILE LOOP TERMINATION: No more nodes in the subtree >>>
 *
 * 10 is returned
 *
 * @param BinarySearchTree $tree
 * @param int $k
 * @return int|null
 */
function findFirstLargerKeyInBst(BinarySearchTree $tree, int $k)
{
    $node = $tree->root;
    $bestFound = null;

    while ($node) {
        if ($node->key > $k) {
            $bestFound = $node->key;

            $node = $node->left;
        } else {
            $node = $node->right;
        }
    }

    return $bestFound;
}

// Valid BST
// Level 0
$root = NodeFactory::makeNode(8);

// Level 1
$left = NodeFactory::makeNode(3, $root);
$right = NodeFactory::makeNode(10, $root);
$root->left = $left;
$root->right = $right;

// Level 2
$leftLeft = NodeFactory::makeNode(1, $left);
$leftRight = NodeFactory::makeNode(6, $left);
$rightRight = NodeFactory::makeNode(14, $right);
$left->left = $leftLeft;
$left->right = $leftRight;
$right->right = $rightRight;

// Level 3
$leftRightLeft = NodeFactory::makeNode(4, $leftRight);
$leftRightRight = NodeFactory::makeNode(7, $leftRight);
$rightRightLeft = NodeFactory::makeNode(13, $rightRight);
$leftRight->left = $leftRightLeft;
$leftRight->right = $leftRightRight;
$rightRight->left = $rightRightLeft;

$binaryTree = new BinarySearchTree($root);
$searchValue = 8;
$result = findFirstLargerKeyInBst($binaryTree, $searchValue);

if ($result !== null) {
    printf('The closest value to %d which is still greater is %d.', $searchValue, $result);
} else {
    printf('There is no value which is greater than %d.', $searchValue);
}

print PHP_EOL;
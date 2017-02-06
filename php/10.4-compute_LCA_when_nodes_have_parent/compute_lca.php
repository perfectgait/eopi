<?php

require_once '../bootstrap.php';

use EOPI\Node;
use EOPI\Factory\NodeFactory;

/**
 * The running time is O(h) where h is the height of the tree, and the space complexity is O(1).
 */

/**
 * Compute the lowest common ancestor of two nodes in a binary tree.  This works by first finding the depth of the two
 * nodes.  If the depths are not the same, the lower of the two node pointers is brought up to the ancestor of the
 * lowest node with the same depth as the other node.  Since both node pointers are at the same depth now, the parents
 * of each are continuously compared until a match is found.  Once a match is found, that is the LCA and the node is
 * returned.
 *
 * i.e.
 * If the input tree is:
 *                  314
 *                 /   \
 *                6     14
 *               / \
 *             271 561
 *            /
 *           15
 * and the nodes are 15 and 561
 *
 * $depth1 = 3
 * $depth2 = 2
 * $distance = 1
 * Is $depth2 > $depth1? No
 *
 * <<< WHILE LOOP BEGIN >>>
 *
 * Iteration 1:
 * $distance = 0
 * $node1 = 271
 *
 * <<< WHILE LOOP TERMINATION: $depth == 0 >>>
 *
 * <<< WHILE LOOP BEGIN >>>
 *
 * Iteration 1:
 * $node1 = 6
 * $node2 = 6
 *
 * <<< WHILE LOOP TERMINATION: $node1->key == $node2->key >>>
 *
 * return the node with key 6 rooted in the left sub-tree of the trees root
 *
 * @param Node $node1
 * @param Node $node2
 * @return Node
 */
function computeLca(Node $node1, Node $node2)
{
    $depth1 = getNodeDepth($node1);
    $depth2 = getNodeDepth($node2);
    $distance = abs($depth1 - $depth2);

    if ($depth2 > $depth1) {
        $temp = $node1;
        $node1 = $node2;
        $node2 = $temp;
    }

    while ($distance) {
        $distance--;
        $node1 = $node1->parent;
    }

    while ($node1->key != $node2->key) {
        $node1 = $node1->parent;
        $node2 = $node2->parent;
    }

    return $node1;
}

/**
 * Get the depth of a node by starting a counter at 0 and then incrementing by 1 until the root node of the tree is
 * reached.
 *
 * @param Node $node
 * @return int
 */
function getNodeDepth(Node $node)
{
    $depth = 0;

    while ($node->parent) {
        $depth++;
        $node = $node->parent;
    }

    return $depth;
}

$root = NodeFactory::makeNode(314);

$left1 = NodeFactory::makeNode(6, $root);
$right1 = NodeFactory::makeNode(6, $root);

$left1_left1 = NodeFactory::makeNode(271, $left1);
$left1_right1 = NodeFactory::makeNode(561, $left1);
$right1_left1 = NodeFactory::makeNode(2, $right1);
$right1_right1 = NodeFactory::makeNode(271, $right1);

$left1left1_left1 = NodeFactory::makeNode(28, $left1_left1);
$left1left1_right1 = NodeFactory::makeNode(0, $left1_left1);
$left1right1_right1 = NodeFactory::makeNode(3, $left1_right1);
$right1left1_right1 = NodeFactory::makeNode(1, $right1_left1);
$right1right1_right1 = NodeFactory::makeNode(28, $right1_right1);

$left1right1right1_left1 = NodeFactory::makeNode(17, $left1right1_right1);
$right1left1right1_left1 = NodeFactory::makeNode(401, $right1left1_right1);
$right1left1right1_right1 = NodeFactory::makeNode(257, $right1left1_right1);

$right1left1right1left1_right1 = NodeFactory::makeNode(641, $right1left1right1_left1);

// Now assign the left/right values
$root->left = $left1;
$root->right = $right1;

$left1->left = $left1_left1;
$left1->right = $left1_right1;
$right1->left = $right1_left1;
$right1->right = $right1_right1;

$left1_left1->left = $left1left1_left1;
$left1_left1->right = $left1left1_right1;
$left1_right1->right = $left1right1_right1;
$right1_left1->right = $right1left1_right1;
$right1_right1->right = $right1right1_right1;

$left1right1_right1->left = $left1right1right1_left1;
$right1left1_right1->left = $right1left1right1_left1;
$right1left1_right1->right = $right1left1right1_right1;

$right1left1right1_left1->right = $right1left1right1left1_right1;

$lca = computeLca($right1left1right1left1_right1, $right1right1_right1);

printf('The LCA for nodes %d and %d is %d.', $right1left1right1left1_right1->key, $right1right1_right1->key, $lca->key);
print PHP_EOL;

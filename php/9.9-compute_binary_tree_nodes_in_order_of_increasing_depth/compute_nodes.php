<?php

require_once '../bootstrap.php';

use EOPI\BinaryTree;
use EOPI\Node;
use EOPI\Factory\NodeFactory;

/**
 * The time complexity is O(n) and the space complexity is O(m) where m is the maximum number of nodes at any level in
 * the tree.
 */

/**
 * Compute the nodes of a binary tree in order of increasing depth, from left to right.  This works by first creating a
 * queue that will be used to traverse through the nodes.  After the queue is created, the root node of the tree is
 * added to it and the count of the number of nodes is computed.  Once this is done it iterates through every node in
 * the queue, adding the current nodes key to the array of current keys.  Then the left and right children are added to
 * the queue if they exist.  Finally a check is made to see if there are any more nodes at the current level.  If there
 * are not, the current keys are added to the final result and reset.  Then the nodes at this level is computed again by
 * counting the number of nodes in the queue.
 * By adding the left and right children of the current node to the queue at each iteration, each node in the tree is
 * visited once.
 *
 * i.e.
 * If the input tree is:
 *                  314
 *                 /   \
 *                6     6
 *               / \
 *             271 561
 *
 * $result = []
 * $currentResult = []
 * $nodes = [314]
 * $nodesAtThisLevel = 1
 *
 * <<< WHILE LOOP BEGIN >>>
 *
 * Iteration 1:
 * $root = 314
 * $nodes = []
 * $currentResult = [314]
 * $nodesAtThisLevel = 0
 * Does $root have a left child? Yes
 * $nodes = [6]
 * Does $root have a right child? Yes
 * $nodes = [6, 6]
 * Are there more nodes at this level? No
 * $result = [[314]]
 * $currentResult = []
 * $nodesAtThisLevel = 2
 *
 * Iteration 2:
 * $root = 6
 * $nodes = [6]
 * $currentResult = [6]
 * $nodesAtThisLevel = 1
 * Does $root have a left child? Yes
 * $nodes = [271, 6]
 * Does $root have a right child? Yes
 * $nodes = [561, 271, 6]
 * Are there more nodes at this level? Yes
 *
 * Iteration 3:
 * $root = 6
 * $nodes = [561, 271]
 * $currentResult = [6, 6]
 * $nodesAtThisLevel = 0
 * Does $root have a left child? No
 * Does $root have a right child? No
 * Are there more nodes at this level? No
 * $result = [[314], [6, 6]]
 * $currentResult = []
 * $nodesAtThisLevel = 2
 *
 * Iteration 4:
 * $root = 271
 * $nodes = [561]
 * $currentResult = [271]
 * $nodesAtThisLevel = 1
 * Does $root have a left child? No
 * Does $root have a right child? No
 * Are there more nodes at this level? Yes
 *
 * Iteration 5:
 * $root = 561
 * $nodes = []
 * $currentResult = [271, 561]
 * $nodesAtThisLevel = 0
 * Does $root have a left child? No
 * Does $root have a right child? No
 * Are there more nodes at this level? No
 * $result = [[314], [6, 6], [271, 561]]
 * $currentResult = []
 * $nodesAtThisLevel = 0
 *
 * <<< WHILE LOOP TERMINATION: $nodes is empty >>>
 *
 * return [[314], [6, 6], [271, 561]]
 *
 * @param BinaryTree $tree
 * @return array
 */
function computeNodesInOrderOfIncreasingDepth(BinaryTree $tree)
{
    if ($tree->isEmpty()) {
        throw new \InvalidArgumentException('The tree cannot be empty');
    }

    $result = [];
    $currentResult = [];
    $nodes = new \SplQueue();
    $nodes->enqueue($tree->root);
    $nodesAtThisLevel = count($nodes);

    while (!$nodes->isEmpty()) {
        /** @var Node $root */
        $root = $nodes->dequeue();
        $currentResult[] = $root->key;
        --$nodesAtThisLevel;

        if ($root->left) {
            $nodes->enqueue($root->left);
        }

        if ($root->right) {
            $nodes->enqueue($root->right);
        }

        // If there are no more nodes at this level, append the current result to the total result and reset it.
        if (!$nodesAtThisLevel) {
            $result[] = $currentResult;
            $currentResult = [];
            $nodesAtThisLevel = count($nodes);
        }
    }

    return $result;
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

$tree = new BinaryTree($root);
$result = computeNodesInOrderOfIncreasingDepth($tree);

print 'The pre-order of the tree is: ' . PHP_EOL;
$tree->preOrder($root);

printf('The result of computing the nodes in order of increasing depth is : %s', json_encode($result));
print PHP_EOL;

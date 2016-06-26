<?php

require_once '../autoload.php';

use EOPI\BinaryTree;
use EOPI\Factory\NodeFactory;
use EOPI\Node;

/**
 * The time complexity is O(n) and the space complexity is O(h) where h is the height of the tree
 */

/**
 * Determine if a binary tree rooted at $node satisfies the binary search tree property (every child in the nodes
 * subtree is less than or equal to the node and every child in the nodes right tree is greater than or equal to the
 * node).  This works by going through each node in the tree and comparing its key to a range of values defined from the
 * previous traversals.  If the value is outside of the range then the tree rooted at that node does not satisfy the BST
 * property.  To get the range of values, start at the root with the range being [-infinity, infinity].  When navigating
 * down the left sub-tree, the new maximum is the key at the root.  This is because all values in the left sub-tree must
 * be <= the value of their parent.  When navigating down the right sub-tree, the new minimum if the key at the root.
 * This is because all values in the right sub-tree must be >= the value of their parent.  Each time a traversal happens
 * the range is updated and the checks continue.  If they all pass, the tree satisfies the BST property.
 *
 * i.e.
 * If the input tree is:
 *                           8
 *                         /   \
 *                        3    10
 *                       / \    \
 *                      1   6   14
 *
 * $node->key = 8
 * $lowRange = -infinity
 * $highRange = infinity
 * Is $node->key < $lowRange or $node->key > $highRange? No
 *
 * <<< Recursive call >>>
 * $node->key = 3
 * $lowRange = -infinity
 * $highRange = 8
 * Is $node->key < $lowRange or $node->key > $highRange? no
 *
 * <<< Recursive call >>>
 * $node->key = 1
 * $lowRange = -infinity
 * $highRange = 3
 * Is $node->key < $lowRange or $node->key > $highRange? no
 *
 * <<< Recursive call >>>
 * $node->key = 6
 * $lowRange = -infinity
 * $highRange = 3
 * Is $node->key < $lowRange or $node->key > $highRange? no
 *
 * <<< Recursive call >>>
 * $node->key = 10
 * $lowRange = 8
 * $highRange = infinity
 * Is $node->key < $lowRange or $node->key > $highRange? no
 *
 * <<< Recursive call >>>
 * $node->key = 14
 * $lowRange = 10
 * $highRange = infinity
 * Is $node->key < $lowRange or $node->key > $highRange? no
 *
 * This tree satisfies the BST property
 *
 * @param Node|null $node
 * @param int $lowRange
 * @param int $highRange
 * @return bool
 */
function testForBstProperty(Node $node = null, $lowRange, $highRange)
{
    if (empty($node)) {
        return true;
    }

    if ($node->key < $lowRange || $node->key > $highRange) {
        return false;
    }

    return testForBstProperty($node->left, $lowRange, $node->key)
        && testForBstProperty($node->right, $node->key, $highRange);
}

/**
 * Determine if a binary tree rooted at $node satisfies the binary search tree property (every child in the nodes
 * subtree is less than or equal to the node and every child in the nodes right tree is greater than or equal to the
 * node).  This works by traversing through each node using BFS and adding an entry to the queue with the current node
 * and the range constraint that the node value must satisfy.  Starting at the root node, the root node is added to the
 * queue along with the range constraint [-infinity, infinity].  Then the left child node of the root is added to the
 * queue with the constraint [-infinity, root node key].  Then the right child node of the root is added to the queue
 * with the constraint [root node key, infinity].  The root node is then popped from the queue.  Each child node key
 * will then be checked against the stored constraints, their children added and then they will be popped.  If any
 * constraint is not met, the binary tree does not satisfy the BST property.
 *
 * i.e.
 * If the input tree is:
 *                           8
 *                         /   \
 *                        3    7
 *                       / \    \
 *                      1   6   14
 *
 * $queue = [
 *  $node (with key 8), -infinity, infinity
 * ]
 * Is 8 < -infinity or > infinity? No
 * $queue = [
 *  $node (with key 3), -infinity, 8
 *  $node (with key 7), 8, infinity
 * ]
 *
 * Is 3 < -infinity or > 8? No
 * Is 7 < 8 or > infinity? Yes
 *
 * This tree does not satisfy the BST property
 *
 * @param Node|null $node
 * @return bool
 */
function testForBstPropertyUsingQueue(Node $node = null)
{
    if (empty($node)) {
        return true;
    }

    $queue = new \SplQueue();
    $queue->enqueue([$node, -9223372036854775808, PHP_INT_MAX]);

    while (!$queue->isEmpty()) {
        if (!empty($queue->current())) {
            if ($queue->current()[0]->key < $queue->current()[1] || $queue->current()[1]->key > $queue->current()[2]) {
                return false;
            }

            $queue->enqueue([$node->left, $queue->current()[1], $queue->current()[0]->key]);
            $queue->enqueue([$node->right, $queue->current()[0]->key], $queue->current()[2]);
        }

        $queue->pop();
    }

    return true;
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

$binaryTree = new BinaryTree($root);
$binaryTree->preOrder($binaryTree->root);
$result = testForBstProperty($binaryTree->root, -9223372036854775808, PHP_INT_MAX);
$result2 = testForBstPropertyUsingQueue($binaryTree->root);

if ($result && $result2) {
    print 'Satisfies the BST property';
} else {
    print 'Does not satisfy the BST property';
}

print PHP_EOL . PHP_EOL;

// Invalid BST
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
$rightRightLeft = NodeFactory::makeNode(2, $rightRight);
$leftRight->left = $leftRightLeft;
$leftRight->right = $leftRightRight;
$rightRight->left = $rightRightLeft;

$binaryTree = new BinaryTree($root);
$binaryTree->preOrder($binaryTree->root);
$result = testForBstProperty($binaryTree->root, -9223372036854775808, PHP_INT_MAX);
$result2 = testForBstPropertyUsingQueue($binaryTree->root);

if ($result && $result2) {
    print 'Satisfies the BST property';
} else {
    print 'Does not satisfy the BST property';
}

print PHP_EOL . PHP_EOL;

// Valid BST
$root = NodeFactory::makeNode(8);

// Level 1
$left = NodeFactory::makeNode(8, $root);
$right = NodeFactory::makeNode(8, $root);
$root->left = $left;
$root->right = $right;

// Level 2
$leftLeft = NodeFactory::makeNode(8, $left);
$leftRight = NodeFactory::makeNode(8, $left);
$rightRight = NodeFactory::makeNode(8, $right);
$left->left = $leftLeft;
$left->right = $leftRight;
$right->right = $rightRight;

// Level 3
$leftRightLeft = NodeFactory::makeNode(8, $leftRight);
$leftRightRight = NodeFactory::makeNode(8, $leftRight);
$rightRightLeft = NodeFactory::makeNode(8, $rightRight);
$leftRight->left = $leftRightLeft;
$leftRight->right = $leftRightRight;
$rightRight->left = $rightRightLeft;

$binaryTree = new BinaryTree($root);
$binaryTree->preOrder($binaryTree->root);
$result = testForBstProperty($binaryTree->root, -9223372036854775808, PHP_INT_MAX);
$result2 = testForBstPropertyUsingQueue($binaryTree->root);

if ($result && $result2) {
    print 'Satisfies the BST property';
} else {
    print 'Does not satisfy the BST property';
}

print PHP_EOL;
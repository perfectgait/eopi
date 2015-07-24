<?php

/**
 * Binary Tree implementation.  This class does not construct a BST randomly so the operations may run in O(n) time.
 */

namespace BinaryTree;

use BinaryTree\Node;

/**
 * Class BinaryTree
 */
class BinaryTree
{
    /**
     * @var Node|null
     */
    public $root;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->root = null;
    }

    /**
     * Find an element in the tree with the specified key
     *
     * @param $key
     * @param \BinaryTree\Node|null $node
     * @return Node|null
     */
    public function search($key, Node $node = null)
    {
        if ($this->isEmpty()) {
            throw new \UnderflowException('tree is empty');
        }

        $node = $node ?: $this->root;

        while ($node && $node->key != $key) {
            if ($key < $node->key) {
                $node = $node->left;
            } else {
                $node = $node->right;
            }
        }

        return $node;
    }

    /**
     * Find the minimum value in the tree
     *
     * @param Node|null $node
     * @return Node
     */
    public function minimum(Node $node = null)
    {
        if ($this->isEmpty()) {
            throw new \UnderflowException('tree is empty');
        }

        $node = $node ?: $this->root;

        while ($node->left != null) {
            $node = $node->left;
        }

        return $node;
    }

    /**
     * Find the maximum value in the tree
     *
     * @param Node|null $node
     * @return Node
     */
    public function maximum(Node $node = null)
    {
        if ($this->isEmpty()) {
            throw new \UnderflowException('tree is empty');
        }

        $node = $node ?: $this->root;

        while ($node->right != null) {
            $node = $node->right;
        }

        return $node;
    }

    /**
     * Find the predecessor of a node
     *
     * @param Node $node
     * @return Node|null
     */
    public function predecessor(Node $node)
    {
        if ($this->isEmpty()) {
            throw new \UnderflowException('tree is empty');
        }

        if ($node->left != null) {
            return $this->maximum($node->left);
        }

        $parent = $node->parent;

        while ($parent != null && $node = $parent->left) {
            $node = $parent;
            $parent = $parent->parent;
        }

        return $parent;
    }

    /**
     * Find the successor of a node
     *
     * @param Node $node
     * @return Node|null
     */
    public function successor(Node $node)
    {
        if ($this->isEmpty()) {
            throw new \UnderflowException('tree is empty');
        }

        if ($node->right != null) {
            return $this->minimum($node->right);
        }

        $parent = $node->parent;

        while ($parent != null && $node = $parent->right) {
            $node = $parent;
            $parent = $parent->parent;
        }

        return $parent;
    }

    /**
     * Insert a node into the tree
     *
     * @param Node $node
     */
    public function insert(Node $node)
    {
        $parent = null;
        $root = $this->root;

        while ($root != null) {
            $parent = $root;

            if ($node->key < $root->key) {
                $root = $root->left;
            } else {
                $root = $root->right;
            }
        }

        $node->parent = $parent;

        // If the tree was empty, this is the new root
        if ($parent == null) {
            $this->root = $node;
        } elseif ($node->key < $parent->key) {
            $parent->left = $node;
        } else {
            $parent->right = $node;
        }
    }

    /**
     * Delete a node from the tree
     *
     * @param Node $node
     */
    public function delete(Node $node)
    {
        if ($this->isEmpty()) {
            throw new \UnderflowException('tree is empty');
        }

        if ($node->left == null) {
            // If the node has no left child, replace it with its own right child
            $this->transplant($node, $node->right);
        } elseif ($node->right == null) {
            // If the node has no right child, replace it with its own left child
            $this->transplant($node, $node->left);
        } else {
            $minimum = $this->minimum($node->right);

            // If the minimum's parent is not the same as the node being deleted, transplant the minimum with its right
            // child.
            if ($minimum->parent != $node) {
                $this->transplant($minimum, $minimum->right);
                $minimum->right = $node->right;
                $minimum->right->parent = $minimum;
            }

            // Transplant the node being deleted with the minimum
            $this->transplant($node, $minimum);
            $minimum->left = $node->left;
            $minimum->left->parent = $minimum;
        }
    }

    /**
     * Perform an in-order tree walk which prints the key of the root between printing the values in its left and right
     * sub-trees.
     *
     * @param Node|null $node
     */
    public function inOrder(Node $node = null)
    {
        if ($this->isEmpty()) {
            throw new \UnderflowException('tree is empty');
        }

        if ($node != null) {
            $this->inOrder($node->left);
            print 'Key: ' . $node->key . PHP_EOL;
            $this->inOrder($node->right);
        }
    }

    /**
     * Perform a pre-order tree walk which prints the key of the root before printing the values in its left and right
     * sub-trees.
     *
     * @param Node|null $node
     */
    public function preOrder(Node $node = null)
    {
        if ($this->isEmpty()) {
            throw new \UnderflowException('tree is empty');
        }

        if ($node != null) {
            print 'Key: ' . $node->key . PHP_EOL;
            $this->preOrder($node->left);
            $this->preOrder($node->right);
        }
    }

    /**
     * Perform a post-order tree walk which prints the key of the root after printing the values in its left and right
     * sub-trees.
     *
     * @param Node|null $node
     */
    public function postOrder(Node $node = null)
    {
        if ($this->isEmpty()) {
            throw new \UnderflowException('tree is empty');
        }

        if ($node != null) {
            $this->postOrder($node->left);
            $this->postOrder($node->right);
            print 'Key: ' . $node->key . PHP_EOL;
        }
    }

    /**
     * Determine if the tree is empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        return $this->root == null;
    }

    /**
     * Transplant a node with another node
     *
     * @param Node $node1
     * @param Node|null $node2
     */
    private function transplant(Node $node1, Node $node2 = null)
    {
        if ($node1->parent == null) {
            // Are we transplanting the root with another node?
            $this->root = $node2;
        } elseif ($node1 = $node1->parent->left) {
            // If node1 was the left child, make node2 the new left child
            $node1->parent->left = $node2;
        } else {
            // If node1 was the right child, make node2 the new right child
            $node1->parent->right = $node2;
        }

        if ($node2 != null) {
            $node2->parent = $node1->parent;
        }
    }
}
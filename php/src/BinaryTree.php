<?php

namespace EOPI;

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
     * BinaryTree constructor.
     *
     * @param Node|null $root
     */
    public function __construct(Node $root = null)
    {
        $this->root = $root ?: null;
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
}
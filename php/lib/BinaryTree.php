<?php

/**
 * Binary Tree implementation.  This class does not construct a BST randomly so the operations may run in O(n) time.
 */

/**
 * Class BinaryTree
 */
class BinaryTree
{
    const MINIMUM_SIZE = 10;
    const GROWTH_FACTOR = 1.5;

    /**
     * @var \SplFixedArray
     */
    private $tree;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tree = new \SplFixedArray(self::MINIMUM_SIZE);
    }

    /**
     * Find an element in the tree with the specified key
     *
     * @param $key
     * @param \stdClass|null $node
     * @return \stdClass
     */
    public function search($key, $node = null)
    {
        if (empty($this->tree)) {
            throw new \UnderflowException('tree is empty');
        }

        $node = $node ?: $this->tree[0];

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
     * @param \stdClass|null $node
     * @return mixed
     */
    public function minimum($node = null)
    {
        if (empty($this->tree)) {
            throw new \UnderflowException('tree is empty');
        }

        $node = $node ?: $this->tree[0];

        while ($node->left != null) {
            $node = $node->left;
        }

        return $node->key;
    }

    /**
     * Find the maximum value in the tree
     *
     * @param \stdClass|null
     * @return mixed
     */
    public function maximum($node = null)
    {
        if (empty($this->tree)) {
            throw new \UnderflowException('tree is empty');
        }

        $node = $node ?: $this->tree[0];

        while ($node->right != null) {
            $node = $node->right;
        }

        return $node->key;
    }

    public function predecessor($value)
    {
        if (empty($this->tree)) {
            throw new \UnderflowException('tree is empty');
        }
    }

    /**
     * Find the successor of a node
     *
     * @param \stdClass $node
     * @return \stdClass
     */
    public function successor(\stdClass $node)
    {
        if (empty($this->tree)) {
            throw new \UnderflowException('tree is empty');
        }

        if ($node->right != null) {
            return $this->minimum($node->right);
        }

        $parent = $node->parent;

        while ()
    }

    public function insert($key)
    {
        $node = new \stdClass();
        $node->key = $key;
    }

    public function delete($node)
    {

    }

    /**
     * Grow the tree by a constant growth factor
     */
    private function grow()
    {
        $this->tree->setSize($this->tree->getSize() * self::GROWTH_FACTOR);
    }
}
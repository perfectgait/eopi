<?php

namespace EOPI\DataStructure;

/**
 * Implementation of a stack that supports a max operation.  The max operation returns the maximum value in the stack.
 * By storing the max value with each item added the max operation runs in O(1) time.
 */

/**
 * Class Stack
 */
class Stack extends \SplStack
{
    /**
     * Push an item onto the stack
     *
     * @param mixed $value
     */
    public function push($value)
    {
        // Convert the $value as necessary
        if (!$value instanceof \stdClass) {
            $item = new \stdClass();
            $item->value = $value;
        } else {
            $item = $value;
        }

        $item->max = max($item->value, $this->isEmpty() ? $item->value : $this->max());

        parent::push($item);
    }

    /**
     * Pop the top item on the stack
     *
     * @return mixed
     */
    public function pop()
    {
        $item = parent::pop();

        return $item->value;
    }

    /**
     * Return the maximum value in the stack
     *
     * @return mixed
     */
    public function max()
    {
        if ($this->isEmpty()) {
            throw new \UnderflowException('stack is empty');
        }

        return $this->top()->max;
    }
}

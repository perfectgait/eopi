<?php

namespace EOPI\DataStructures;

class ObjectMaxHeap extends \SplMaxHeap
{
    /**
     * Compare any two objects that have a getValue method.
     *
     * @param mixed $object1
     * @param mixed $object2
     * @return int
     * @throws \Exception
     */
    protected function compare($object1, $object2)
    {
        if (method_exists($object1, 'getValue') && method_exists($object2, 'getValue')) {
            if ($object1->getValue() > $object2->getValue()) {
                return 1;
            } elseif ($object1->getValue() === $object2->getValue()) {
                return 0;
            }

            return -1;
        }

        throw new \Exception('Both objects must have a getValue method');
    }
}

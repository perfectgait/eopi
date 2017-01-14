<?php

namespace EOPI\DataStructures;

/**
 * Class ListNode
 */
class ListNode
{
    /**
     * @var mixed
     */
    public $value;

    /**
     * @var ListNode|null
     */
    public $next;

    /**
     * @var ListNode|null
     */
    public $previous;
}
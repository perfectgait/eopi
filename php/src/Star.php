<?php

namespace EOPI;

/**
 * Class Star
 * @package EOPI
 */
class Star
{
    /**
     * @var int
     */
    public $x;

    /**
     * @var int
     */
    public $y;

    /**
     * @var int
     */
    public $z;

    /**
     * @param int $x
     * @param int $y
     * @param int $z
     */
    public function __construct($x, $y, $z)
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('(%d, %d, %d)', $this->x, $this->y, $this->z);
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->x * $this->x + $this->y * $this->y + $this->z * $this->z;
    }
}

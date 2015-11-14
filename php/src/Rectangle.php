<?php

/**
 * Rectangle with x/y coordinates, width and height
 */

namespace EOPI;

/**
 * Class Rectangle
 */
class Rectangle
{
    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @param int $x
     * @param int $y
     * @param int $width
     * @param int $height
     */
    public function __construct($x, $y, $width, $height)
    {
        if (!is_int($x)) {
            throw new \InvalidArgumentException('$x must be an integer');
        }

        if (!is_int($y)) {
            throw new \InvalidArgumentException('$y must be an integer');
        }

        if (!is_int($width)) {
            throw new \InvalidArgumentException('$width must be an integer');
        }

        if (!is_int($height)) {
            throw new \InvalidArgumentException('$height must be an integer');
        }

        $this->x = $x;
        $this->y = $y;
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Represent the rectangle via a string
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('{x: %d, y: %d, width: %d, height: %d}', $this->x, $this->y, $this->width, $this->height);
    }

    /**
     * Get x
     *
     * @return int
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Get y
     *
     * @return int
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Get height
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Get width
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }
}
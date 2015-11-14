<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;
use EOPI\Rectangle;

/**
 * The time complexity is O(1) since the number of operations is constant
 */

/**
 * Get the intersection of two rectangles.  This works by first checking to see if the rectangles exist.  If they do,
 * the intersecting rectangle is returned.  The intersecting rectangle is formed by using the largest x and y values
 * from the two rectangles.  The width is formed by subtracting the length of the smallest x-axis side from the largest
 * x value of the two rectangles.  The height is formed by subtracting the length of the smallest y-axis side from the
 * largest y value of the two rectangles.
 *
 * If the two rectangles are {x: 2, y: 1, width: 2, height: 2} and {x: 3, y: 0, width: 4, height: 2}
 *
 * We know they intersect based on the proof in the rectanglesIntersect docblock.
 *
 * The x-coordinate of the intersecting rectangle is 3 because the second rectangles x-coordinate is larger than the first rectangles x-coordinate
 * The y-coordinate of the intersecting rectangle is 1 because the first rectangles y-coordinate is larger than the second rectangles y-coordinate
 * The width of the intersecting rectangle is 1 because the first rectangles x-coordinate(2) + the first rectangles
 * width(2) = 4 is less than the second rectangles x-coordinate(3) + the second rectangles width(4) = 7.  The second
 * rectangles x-coordinate(3) is greater than the first rectangles x-coordinate(2).  We end up with 4 - 3 = 1.
 *
 * The height of the intersecting rectangle is 1 because the second rectangles y-coordinate(0) + the second rectangles
 * height(2) = 2 is less than the first rectangles y-coordinate(1) + the first rectangles height(2) = 3.  The first
 * rectangles y-coordinate(1) is greater than the second rectangles y-coordinate(0).  We end up with 2 - 1 = 1.
 *
 * This is much easier to see by just drawing out a graph and plotting the rectangles.
 *
 * @param Rectangle $firstRectangle
 * @param Rectangle $secondRectangle
 * @return Rectangle
 */
function getIntersectingRectangle(Rectangle $firstRectangle, Rectangle $secondRectangle)
{
    if (rectanglesIntersect($firstRectangle, $secondRectangle)) {
        return new Rectangle(
            max($firstRectangle->getX(), $secondRectangle->getX()),
            max($firstRectangle->getY(), $secondRectangle->getY()),
            min($firstRectangle->getX() + $firstRectangle->getWidth(), $secondRectangle->getX() + $secondRectangle->getWidth()) - max($firstRectangle->getX(), $secondRectangle->getX()),
            min($firstRectangle->getY() + $firstRectangle->getHeight(), $secondRectangle->getY() + $secondRectangle->getHeight()) - max($firstRectangle->getY(), $secondRectangle->getY())
        );
    } else {
        return new Rectangle(0, 0, -1, -1);
    }
}

/**
 * Determine if two rectangles intersect.  This works by checking to see if the x value of $firstRectangle lies
 * anywhere on the line ($secondRectangle->x, $secondRectangle->x + $secondRectangle->height).  Then it checks to see if
 * the y value of $firstRectangle lies anywhere on the line ($secondRectangle->y, $secondRectangle->y +
 * $secondRectangle->height).  If both cases are true, the rectangles intersect.
 *
 * If the two rectangles are {x: 2, y: 1, width: 2, height: 2} and {x: 3, y: 0, width: 4, height: 2}
 *
 * Is the first rectangles x-coordinate(2) <= the second rectangles x-coordinate(3) + the second rectangles width(4) = 7? YES
 * Is the first rectangles x-coordinate(2) + the first rectangles width(2) = 4 >= the second rectangles x-coordinate(3)? YES
 * Is the first rectangles y-coordinate(1) <= the second rectangles y-coordinate(0) + the second rectangles height(2) = 2? YES
 * Is the first rectangles y-coordinate(1) + the first rectangles height(2) = 3 >= the second rectangles y-coordinate(0)? YES
 *
 * They intersect
 *
 * @param Rectangle $firstRectangle
 * @param Rectangle $secondRectangle
 * @return bool
 */
function rectanglesIntersect(Rectangle $firstRectangle, Rectangle $secondRectangle)
{
    return $firstRectangle->getX() <= $secondRectangle->getX() + $secondRectangle->getWidth()
        && $firstRectangle->getX() + $firstRectangle->getWidth() >= $secondRectangle->getX()
        && $firstRectangle->getY() <= $secondRectangle->getY() + $secondRectangle->getHeight()
        && $firstRectangle->getY() + $firstRectangle->getHeight() >= $secondRectangle->getY();
}

$inputHelper = new InputHelper();
$firstX = (int)$inputHelper->readInputFromStdIn('Enter the x coordinate of the first rectangle: ');
$firstY = (int)$inputHelper->readInputFromStdIn('Enter the y coordinate of the first rectangle: ');
$firstWidth = (int)$inputHelper->readInputFromStdIn('Enter the width of the first rectangle: ');
$firstHeight = (int)$inputHelper->readInputFromStdIn('Enter the height of the first rectangle: ');
$secondX = (int)$inputHelper->readInputFromStdIn('Enter the x coordinate of the second rectangle: ');
$secondY = (int)$inputHelper->readInputFromStdIn('Enter the y coordinate of the second rectangle: ');
$secondWidth = (int)$inputHelper->readInputFromStdIn('Enter the width of the second rectangle: ');
$secondHeight = (int)$inputHelper->readInputFromStdIn('Enter the height of the second rectangle: ');
$firstRectangle = new Rectangle($firstX, $firstY, $firstWidth, $firstHeight);
$secondRectangle = new Rectangle($secondX, $secondY, $secondWidth, $secondHeight);
$result = getIntersectingRectangle($firstRectangle, $secondRectangle);

printf('The intersection of rectangles %s and %s is %s', $firstRectangle, $secondRectangle, $result);

print PHP_EOL;
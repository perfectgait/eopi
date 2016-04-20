<?php

require_once '../bootstrap.php';

use EOPI\Helper\InputHelper;

/**
 * The time complexity is O(1) and the space complexity is O(1)
 */

/**
 * Compute the coordinate of the last spiral ordered element in an m x n 2D array.  This works by first computing the
 * direction the last element was traveling when it stopped.  It does this by checking to see if the m x n 2D is a
 * square.
 *
 * If it's not square and the smallest dimension is odd, the direction being travelled is South or East.  If the width
 * is > the height, the x-coordinate will have to be increased.  If the height is > the width, the y-coordinate will
 * have to be increased.
 *
 * If the smallest dimension is even, or it's a square 2D array, the direction being travelled is North or West.
 *
 * After the direction being travelled is computed, there are 2 possibilities.  If the direction is South or East, the
 * last position for the largest square 2D array that will fit is calculated.  It is then padded by the length of the
 * largest dimension - the smallest dimension.  If the direction is North or West, the last position for the largest
 * square 2D array that will fit is calculated.  In that case it's done.
 *
 * i.e.
 * If the $width is 3 and the $height is 8
 *
 * Is 3 != 8 && 3 % 2 != 0? Yes
 * Is 3 > 8? No
 * $coordinate[0] = floor(3 / 2) + 8 - 3 = 1 + 8 - 3 = 6
 * $coordinate[1] = floor(3 / 2) = 1
 *
 * $coordinate = [6, 1]
 *
 * [ , , ] Which is the same as the last position in [ , , ] after moving the X down 5 which is $height(8) - $width(3).
 * [ , , ]                                           [ ,X, ]
 * [ , , ]                                           [ , , ]
 * [ , , ]
 * [ , , ]
 * [ , , ]
 * [ ,X, ]
 * [ , , ]
 *
 * ===========================================
 *
 * If the $width is 4 and the $height is 6
 *
 * Is 4 != 6 && 4 % 2 != 0? No
 * $coordinate[0] = floor(4 / 2) = 2
 * Is 4 % 2 == 0? Yes
 * $coordinate[1] = floor(4 / 2) - 1 = 2 - 1 = 1
 *
 * $coordinate = [2, 1]
 *
 * [ , , , ] Which is the same as the last position in [ , , , ]
 * [ , , , ]                                           [ , , , ]
 * [ ,X, , ]                                           [ ,X, , ]
 * [ , , , ]                                           [ , , , ]
 * [ , , , ]
 * [ , , , ]
 *
 * ===========================================
 *
 * If the $width is 9 and the $height is 3
 *
 * Is 9 != 3 && 3 % 2 != 0? Yes
 * Is 9 > 3? Yes
 * $coordinate[0] = floor(3 / 2) = 1
 * $coordinate[1] = floor(3 / 2) + 9 - 3 = 1 + 9 - 3 = 7
 *
 * $coordinate = [1, 7]
 *
 * [ , , , , , , , , ] Which is the same as the last position in [ , , ] after moving the X right 6 which is $width(9) - $height(3)
 * [ , , , , , , ,X, ]                                           [ ,X, ]
 * [ , , , , , , , , ]                                           [ , , ]
 *
 *
 * ===========================================
 *
 * If the $width is 10 and the $height is 4
 *
 * Is 10 != 4 && 4 % 2 != 0? No
 * $coordinate[0] = floor(4 / 2) = 2
 * Is 4 % 2 == 0? Yes
 * $coordinate[1] = floor(4 / 2) - 1 = 2 - 1 = 1
 *
 * $coordinate = [2, 1]
 *
 * [ , , , , , , , , , ] Which is the same as the last position in [ , , , ]
 * [ , , , , , , , , , ]                                           [ , , , ]
 * [ ,X, , , , , , , , ]                                           [ ,X, , ]
 * [ , , , , , , , , , ]                                           [ , , , ]
 *
 * @param int $width
 * @param int $height
 * @return array
 */
function computeLastSpiralOrderedElementsCoordinate($width, $height)
{
    if ($width < 1 || $height < 1) {
        throw new \InvalidArgumentException('$width and $height must be >= 1');
    }

    // If the width is 1, the last element is the first element in the last array
    if ($width == 1) {
        return [$height - 1, 0];
    }

    // If the height is 1, the last element is the last element in the first array
    if ($height == 1) {
        return [0, $width - 1];
    }

    $coordinate = [null, null];

    // In this scenario the last element will be on the path going either South or East.  In that case we need to add
    // the extra distance traveled to either the x-coordinate or y-coordinate accordingly.
    if ($width != $height && (min($width, $height) % 2) != 0) {
        if ($width > $height) {
            $coordinate[0] = floor($height / 2);
            $coordinate[1] = floor($height / 2) + $width - $height;
        } else {
            $coordinate[0] = floor($width / 2) + $height - $width;
            $coordinate[1] = floor($width / 2);
        }
    // In this scenario the last element will be on the path going either North or West.  Computing the last element of
    // a min($width, $height) x min($width, $height) 2D array computes the correct answer.
    } else {
        $coordinate[0] = floor(min($width, $height) / 2);

        // If the width is even, the last element cannot be directly in the middle, subtract 1.
        if ((min($width, $height) % 2) == 0) {
            $coordinate[1] = floor(min($width, $height) / 2) - 1;
        } else {
            $coordinate[1] = floor(min($width, $height) / 2);
        }
    }

    return $coordinate;
}

$inputHelper = new InputHelper();
$width = $inputHelper->readInputFromStdIn('Enter the width of the 2D matrix: ');
$height = $inputHelper->readInputFromStdIn('Enter the height of the 2D matrix: ');
$result = computeLastSpiralOrderedElementsCoordinate($width, $height);

printf('The last element in the %d x %d array is at position %s', $width, $height, json_encode($result));
print PHP_EOL;
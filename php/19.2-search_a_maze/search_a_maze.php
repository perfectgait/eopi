<?php

require_once '../autoload.php';

use \EOPI\Helper\InputHelper;
use \EOPI\Helper\OutputHelper;

/**
 * The running time is O(|V| + |E|) (the same as DFS) and the space complexity is O(n * m) where n and m are the
 * dimensions of the maze.  If the maze were totally open you could travel anywhere.
 */

/**
 * Search a maze.  This works by creating the path, pushing the starting coordinate to it and then calling the recursive
 * search function to see if a complete path can be found.
 *
 * @param array $maze
 * @param array $start
 * @param array $end
 * @return \SplStack|bool
 */
function searchMaze(array $maze, array $start, array $end)
{
    $path = new \SplStack();
    $path->push($start);
    $maze[$start[0]][$start[1]] = 1;

    if (recursiveSearch($start, $maze, $end, $path)) {
        return $path;
    }

    return false;
}

/**
 * Recursively search a maze for a path from the start to the end.  This works by first checking to see if the
 * coordinate being searched is the end point.  If so, a complete path is found.  If not, then the four cardinal
 * directions leading away from the coordinate are checked to see if they can be visited.  If so, the new coordinate is
 * pushed on to the path, the coordinate is marked as visited in the maze and this function is recursively called again.
 * If the recursive call succeeds then a path can be found and true is returned.  If the recursive call fails, the last
 * coordinate pushed on to the path is popped off and the next coordinate in the four cardinal directions going away
 * from the current coordinate is searched.  If none of the remaining cardinal directions can be visited, no path can be
 * found from start to finish and the search is over.
 *
 * @param array $coordinate
 * @param array $maze
 * @param array $end
 * @param SplStack $path
 * @return bool
 */
function recursiveSearch(array $coordinate, array $maze, array $end, \SplStack &$path)
{
    if ($coordinate[0] == $end[0] && $coordinate[1] == $end[1]) {
        return true;
    }

    $directions = [
        [0, 1],
        [1, 0],
        [0, -1],
        [-1, 0]
    ];

    foreach ($directions as $direction) {
        if (canVisitCoordinate([$coordinate[0] + $direction[0], $coordinate[1] + $direction[1]], $maze)) {
            $path->push([$coordinate[0] + $direction[0], $coordinate[1] + $direction[1]]);
            $maze[$coordinate[0] + $direction[0]][$coordinate[1] + $direction[1]] = 1;

            if (recursiveSearch([$coordinate[0] + $direction[0], $coordinate[1] + $direction[1]], $maze, $end, $path)) {
                return true;
            }

            $path->pop();
        }
    }

    return false;
}

/**
 * Determine if the coordinate can be visited in the given maze.  This checks to ensure that the coordinate falls
 * somewhere in the maze and that the coordinate can be visited.
 *
 * @param int[] $coordinate
 * @param int[][] $maze
 * @return bool
 */
function canVisitCoordinate(array $coordinate, array $maze)
{
    return $coordinate[0] >= 0
        && $coordinate[1] >= 0
        && $coordinate[0] < count($maze)
        && $coordinate[1] < count($maze[$coordinate[0]])
        && $maze[$coordinate[0]][$coordinate[1]] != 1;
}

$inputHelper = new InputHelper();
$outputHelper = new OutputHelper();
$maze = json_decode($inputHelper->readInputFromStdIn('Enter the maze as a json encoded, multi-dimensional array: '));
$start = json_decode($inputHelper->readInputFromStdIn('Enter the starting coordinate as a json encoded array: '));
$end = json_decode($inputHelper->readInputFromStdIn('Enter the ending coordinate as a json encoded array: '));
$path = searchMaze($maze, $start, $end);

print 'The maze being searched is:' . PHP_EOL . PHP_EOL;
$outputHelper->printFormatted2DArrayToStdOut($maze);
print PHP_EOL;

if ($path) {
    print 'There is a path available from the start to the end of the maze' . PHP_EOL . PHP_EOL;

    while (!$path->isEmpty()) {
        $coordinate = $path->pop();
        $maze[$coordinate[0]][$coordinate[1]] = 'X';
    }

    $outputHelper->printFormatted2DArrayToStdOut($maze);
} else {
    print 'There is no path available from the start to the end of the maze';
}

print PHP_EOL;
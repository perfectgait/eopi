<?php

require_once '../autoload.php';

use \EOPI\Helper\InputHelper;

/**
 * The time complexity for computing combinations is O(sn) and the space complexity is O(s) where s is the number of
 * scores and n is the number of plays.
 * The time complexity for computing permutations is O(sn) and the space complexity is O(s) where s is the number of
 * scores and n is the number of plays.
 */

/**
 * Compute the number of combinations using the set of plays that will achieve the specified score.  This works by
 * going through each play and for each play going through every score in the set [$play, $score].  If the score,
 * $score - $play can be achieved, then $score can be achieved by just adding $play to $score - $play.  This means
 * that the number of ways the current score can be achieved is the same as the number of ways that the current score
 * - the play can be achieved.  We can observe that by going through each play then each score, we will compute the
 * number of combinations.  If the plays are scored in different orders they only count once.
 * At the end of all the iterations, the number of combinations for each score in the set [0, $score] has been
 * calculated.  We just need to return the number of combinations for the $score.
 *
 * i.e.
 * If the score is 7 and the plays are [2, 5]
 *
 * $combinations = [1, 0, 0, 0, 0, 0, 0, 0]
 *
 * <<< FOREACH LOOP BEGIN >>>
 *
 * Iteration 1:
 * $play = 2
 *
 *      <<< FOR LOOP BEGIN >>>
 *
 *      Iteration 1:
 *      $i = 2
 *      $combinations = [1, 0, 1, 0, 0, 0, 0, 0]
 *
 *      Iteration 2:
 *      $i = 3
 *      $combinations = [1, 0, 1, 0, 0, 0, 0, 0]
 *
 *      Iteration 3:
 *      $i = 4
 *      $combinations = [1, 0, 1, 0, 1, 0, 0, 0]
 *
 *      Iteration 4:
 *      $i = 5;
 *      $combinations = [1, 0, 1, 0, 1, 0, 0, 0]
 *
 *      Iteration 5:
 *      $i = 6
 *      $combinations = [1, 0, 1, 0, 1, 0, 1, 0]
 *
 *      Iteration 6:
 *      $i = 7
 *      $combinations = [1, 0, 1, 0, 1, 0, 1, 0]
 *
 *      <<< FOR LOOP TERMINATION: $i = $score + 1 >>>
 *
 * Iteration 2:
 * $play = 5
 *
 *      <<< FOR LOOP BEGIN >>>
 *
 *      Iteration 1:
 *      $i = 5
 *      $combinations = [1, 0, 1, 0, 1, 1, 1, 0]
 *
 *      Iteration 2:
 *      $i = 6
 *      $combinations = [1, 0, 1, 0, 1, 1, 1, 0]
 *
 *      Iteration 3:
 *      $i = 7
 *      $combinations = [1, 0, 1, 0, 1, 1, 1, 1]
 *
 *      <<< FOR LOOP TERMINATION: $i = $score + 1 >>>
 *
 * <<< FOREACH LOOP TERMINATION: All plays have been iterated >>>
 *
 * The number of combinations to score 7 points is 2
 *
 * @param int $score
 * @param int[] $plays
 * @return mixed
 */
function computeCombinations($score, $plays)
{
    if ($score < 0 || $score > PHP_INT_MAX || !is_int($score)) {
        throw new \InvalidArgumentException('$score must be an integer between 0 and ' . PHP_INT_MAX);
    }

    if (!is_array($plays) || empty($plays)) {
        throw new \InvalidArgumentException('$plays must be a non-empty array');
    }

    $combinations = array_fill(0, $score + 1, 0);
    // There is only one way to score 0 points
    $combinations[0] = 1;

    foreach ($plays as $play) {
        if ($play < 0) {
            throw new \InvalidArgumentException('negative value plays are not handled');
        }

        for ($i = $play; $i <= $score; $i++) {
            $combinations[$i] += $combinations[$i - $play];
        }
    }

    return $combinations[$score];
}

/**
 * Compute the number of permutations using the set of plays that will achieve the specified score.  This works by going
 * through each score and for each score going through each play.  If the score, $score - $play can be achieved, then
 * $score can be achieved by just adding $play to $score - $play.  This means that the number of ways the current play
 * can achieve the current score is the same as the number of ways that the current score - the current play can be
 * achieved.  We can observe that by going through each score then each play, we will compute the total number of
 * permutations.  If the plays are scored in different orders they still count.
 * At the end of all the iterations, the number of permutations for each score in the set [0, $score] has been
 * calculated.  We just need to return the number of permutations for the $score.
 *
 * i.e.
 * If the score is 7 and the plays are [2, 5]
 *
 * $permutations = [1, 0, 0, 0, 0, 0, 0, 0]
 *
 * <<< FOR LOOP BEGIN >>>
 *
 * Iteration 1:
 * $i = 0
 *
 *      <<< FOREACH LOOP BEGIN >>>
 *
 *      Iteration 1:
 *      $play = 2
 *      $permutations = [1, 0, 0, 0, 0, 0, 0, 0]
 *
 *      Iteration 2:
 *      $play = 5
 *      $permutations = [1, 0, 0, 0, 0, 0, 0, 0]
 *
 *      <<< FOREACH LOOP TERMINATION: All plays have been iterated >>>
 *
 * Iteration 2:
 * $i = 1
 *
 *      <<< FOREACH LOOP BEGIN >>>
 *
 *      Iteration 1:
 *      $play = 2
 *      $permutations = [1, 0, 0, 0, 0, 0, 0, 0]
 *
 *      Iteration 2:
 *      $play = 5
 *      $permutations = [1, 0, 0, 0, 0, 0, 0, 0]
 *
 *      <<< FOREACH LOOP TERMINATION: All plays have been iterated >>>
 *
 * Iteration 3:
 * $i = 2
 *
 *      <<< FOREACH LOOP BEGIN >>>
 *
 *      Iteration 1:
 *      $play = 2
 *      $permutations = [1, 0, 1, 0, 0, 0, 0, 0]
 *
 *      Iteration 2:
 *      $play = 5
 *      $permutations = [1, 0, 1, 0, 0, 0, 0, 0]
 *
 *      <<< FOREACH LOOP TERMINATION: All plays have been iterated >>>
 *
 * Iteration 4:
 * $i = 3
 *
 *      <<< FOREACH LOOP BEGIN >>>
 *
 *      Iteration 1:
 *      $play = 2
 *      $permutations = [1, 0, 1, 0, 0, 0, 0, 0]
 *
 *      Iteration 2:
 *      $play = 5
 *      $permutations = [1, 0, 1, 0, 0, 0, 0, 0]
 *
 *      <<< FOREACH LOOP TERMINATION: All plays have been iterated >>>
 *
 * Iteration 5:
 * $i = 4
 *
 *      <<< FOREACH LOOP BEGIN >>>
 *
 *      Iteration 1:
 *      $play = 2
 *      $permutations = [1, 0, 1, 0, 1, 0, 0, 0]
 *
 *      Iteration 2:
 *      $play = 5
 *      $permutations = [1, 0, 1, 0, 1, 0, 0, 0]
 *
 *      <<< FOREACH LOOP TERMINATION: All plays have been iterated >>>
 *
 * Iteration 6:
 * $i = 5
 *
 *      <<< FOREACH LOOP BEGIN >>>
 *
 *      Iteration 1:
 *      $play = 2
 *      $permutations = [1, 0, 1, 0, 1, 0, 0, 0]
 *
 *      Iteration 2:
 *      $play = 5
 *      $permutations = [1, 0, 1, 0, 1, 1, 0, 0]
 *
 *      <<< FOREACH LOOP TERMINATION: All plays have been iterated >>>
 *
 * Iteration 7:
 * $i = 6
 *
 *      <<< FOREACH LOOP BEGIN >>>
 *
 *      Iteration 1:
 *      $play = 2
 *      $permutations = [1, 0, 1, 0, 1, 1, 1, 0]
 *
 *      Iteration 2:
 *      $play = 5
 *      $permutations = [1, 0, 1, 0, 1, 1, 1, 0]
 *
 *      <<< FOREACH LOOP TERMINATION: All plays have been iterated >>>
 *
 * Iteration 8:
 * $i = 7
 *
 *      <<< FOREACH LOOP BEGIN >>>
 *
 *      Iteration 1:
 *      $play = 2
 *      $permutations = [1, 0, 1, 0, 1, 1, 1, 1]
 *
 *      Iteration 2:
 *      $play = 5
 *      $permutations = [1, 0, 1, 0, 1, 1, 1, 2]
 *
 *      <<< FOREACH LOOP TERMINATION: All plays have been iterated >>>
 *
 * <<< FOR LOOP TERMINATION: $i = $score + 1 >>>
 *
 * The number of permutations to score 7 points is 2
 *
 * @param int $score
 * @param int[] $plays
 * @return int
 */
function computePermutations($score, $plays)
{
    if ($score < 0 || $score > PHP_INT_MAX || !is_int($score)) {
        throw new \InvalidArgumentException('$score must be an integer between 0 and ' . PHP_INT_MAX);
    }

    if (!is_array($plays) || empty($plays)) {
        throw new \InvalidArgumentException('$plays must be a non-empty array');
    }

    $permutations = array_fill(0, $score + 1, 0);
    // There is only one way to score 0 points
    $permutations[0] = 1;

    for ($i = 0; $i <= $score; $i++) {
        foreach ($plays as $play) {
            if ($play < 0) {
                throw new \InvalidArgumentException('negative value plays are not handled');
            }

            // If the play can achieve the current score
            if ($i >= $play) {
                $permutations[$i] += $permutations[$i - $play];
            }
        }
    }
    
    return $permutations[$score];
}

$inputHelper = new InputHelper();
$score = (int)$inputHelper->readInputFromStdIn('Enter the aggregate score: ');
$plays = json_decode($inputHelper->readInputFromStdIn('Enter the set of plays as a json encoded array: '));
$combinations = computeCombinations($score, $plays);
$permutations = computePermutations($score, $plays);

printf(
    'The combinations to achieve an aggregate score of %d using plays that can score %s is %d',
    $score,
    json_encode($plays),
    $combinations
);
print PHP_EOL;

printf(
    'The permutations to achieve an aggregate score of %d using plays that can score %s is %d',
    $score,
    json_encode($plays),
    $permutations
);
print PHP_EOL;
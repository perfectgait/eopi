#17.1 Count The Number Of Score Combinations
In an American football game, a play can lead to 2 points (safety), 3
points (field goal) or 7 points (touchdown, assuming the extra point).
Given the final score of a game, we want to compute how many different
combinations of 2, 3 and 7 point plays could make up this score.
For example, if W = [2, 3, 7], four combinations of plays yield a score
of 12

- 6 safeties (2 x 6 = 12)
- 3 safeties and 2 field goalds (2 x 3 + 3 x 2 = 12)
- 1 safety, 1 field goal and 1 touchdown (2 x 1 + 3 x 1 + 7 x 1 = 12)
- 4 field goals (3 x 4 = 12)

You have an aggregate score s and W which specifies the points that can
be scored in an individual play.  How would you find the number of
combinations of plays that result in an aggregate score of s?  How would
you compute the number of distinct sequences of individual plays that
result in a score of s?

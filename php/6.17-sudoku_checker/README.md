#6.17 The Sudoku Checker Problem
Sudoku is a populate logic-based combinatorial number placement puzzle.  The objective is to fill a 9 x 9 grid with
digits subject to the constraint that each column, each row and each of the nine 3 x 3 sub-grids that compose the grid
contains unique integers in [1, 9].  The grid is initialized with a partial assignment.
Check whether a 9 x 9 2D array representing a partially completed Sudoku is valid.  Specifically, check that no row,
column and 3 x 3 2D sub-array contains duplicates.  A 0-value in the 2D array indicates that entry is blank; every other
entry is in [1, 9].
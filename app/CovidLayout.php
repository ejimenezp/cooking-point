<?php

namespace App;

class CovidLayout
{

      const seatsArray = [

      // just one group
      ['pattern' => [1, 0, 0], 'cooking' => [31], 'eating' => [41]],
      ['pattern' => [2, 0, 0], 'cooking' => [31,32], 'eating' => [41,43]],
      ['pattern' => [3, 0, 0], 'cooking' => [22,31,32], 'eating' => [32,41,52]],
      ['pattern' => [4, 0, 0], 'cooking' => [21,22,31,32], 'eating' => [32,41,52,61]],
      ['pattern' => [5, 0, 0], 'cooking' => [22,31,32,41,42], 'eating' => [32,41,44,52,61]],
      ['pattern' => [6, 0, 0], 'cooking' => [21,22,31,32,41,42], 'eating' => [32,41,43,45,52,61]],
      ['pattern' => [7, 0, 0], 'cooking' => [12,21,22,31,32,41,42], 'eating' => [22,31,32,41,52,61,62]],
      ['pattern' => [8, 0, 0], 'cooking' => [11,12,21,22,31,32,41,42], 'eating' => [22,31,32,41,52,61,62,71]],
      ['pattern' => [9, 0, 0], 'cooking' => [12,21,22,31,32,41,42,51,52], 'eating' => [22,31,32,41,44,52,61,62,71]],
      ['pattern' => [10, 0, 0], 'cooking' => [11,12,21,22,31,32,41,42,51,52], 'eating' => [22,31,32,41,43,45,52,61,62,71]],
      ['pattern' => [11, 0, 0], 'cooking' => [11,12,21,22,31,32,41,42,51,52,82], 'eating' => [12,21,22,31,32,41,52,61,62,71,72]],
      ['pattern' => [12, 0, 0], 'cooking' => [11,12,21,22,31,32,41,42,51,52,81,82], 'eating' => [12,21,22,31,32,41,52,61,62,71,72,81]],

      // combinations of 2 groups
      ['pattern' => [1, 1, 0], 'cooking' => [21,  31], 'eating' => [31, 52]],
      ['pattern' => [2, 1, 0], 'cooking' => [21,  31,32], 'eating' => [62, 32,41]],
      ['pattern' => [2, 2, 0], 'cooking' => [21,22,  41,42], 'eating' => [22,31, 52,61]],
      ['pattern' => [3, 1, 0], 'cooking' => [21,  31,32,41], 'eating' => [62, 32,41,52]],
      ['pattern' => [3, 2, 0], 'cooking' => [21,22,  32,41,42], 'eating' => [62,71, 32,41,52]],
      ['pattern' => [3, 3, 0], 'cooking' => [12,21,22,  32,41,42], 'eating' => [22,62,71, 32,41,52]],
      ['pattern' => [4, 1, 0], 'cooking' => [21,  31,32,41,42], 'eating' => [71, 32,41,52,61]],
      ['pattern' => [4, 2, 0], 'cooking' => [11,12,  31,32,41,42], 'eating' => [12,21, 32,41,52,61]],
      ['pattern' => [4, 3, 0], 'cooking' => [11,12,21,  31,32,41,42], 'eating' => [12,21,72, 32,41,52,61]],
      ['pattern' => [4, 4, 0], 'cooking' => [11,12,21,22,  41,42,51,52], 'eating' => [12,21,72,81, 32,41,52,61]],
      ['pattern' => [5, 1, 0], 'cooking' => [12,  22,31,32,41,42], 'eating' => [71, 32,41,44,52,61]],
      ['pattern' => [5, 2, 0], 'cooking' => [21,22,  32,41,42,51,52], 'eating' => [12,21, 32,41,44,52,61]],
      ['pattern' => [5, 3, 0], 'cooking' => [12,21,22,  32,41,42,51,52], 'eating' => [12,21,72, 32,41,44,52,61]],
      ['pattern' => [5, 4, 0], 'cooking' => [11,12,21,22,  32,41,42,51,52], 'eating' => [12,21,72,81,  32,41,44,52,61]],
      ['pattern' => [5, 5, 0], 'cooking' => [11,12,21,81,82,  32,41,42,51,52], 'eating' => [12,21,22,72,81,  32,41,44,52,61]],
      ['pattern' => [5, 5, 0], 'cooking' => [11,12,21,81,82,  32,41,42,51,52], 'eating' => [12,21,22,72,81,  32,41,44,52,61]],
      ['pattern' => [6, 1, 0], 'cooking' => [21,  31,32,41,42,51,52], 'eating' => [71, 32,41,43,45,52,61]],
      ['pattern' => [6, 2, 0], 'cooking' => [11,12,  31,32,41,42,51,52], 'eating' => [12,21, 32,41,43,45,52,61]],
      ['pattern' => [6, 3, 0], 'cooking' => [11,12,21,  31,32,41,42,51,52], 'eating' => [12,21,72, 32,41,43,45,52,61]],
      ['pattern' => [6, 4, 0], 'cooking' => [11,12,81,82,  31,32,41,42,51,52], 'eating' => [12,21,72,81,  32,41,43,45,52,61]],
      ['pattern' => [6, 5, 0], 'cooking' => [11,12,21,81,82,   31,32,41,42,51,52], 'eating' => [12,21,22,72,81,  32,41,43,45,52,61]],
      ['pattern' => [6, 6, 0], 'cooking' => [11,12,21,22,81,82,   31,32,41,42,51,52], 'eating' => [11,12,21,22,81,82,  32,41,43,45,52,61]],
      ['pattern' => [7, 1, 0], 'cooking' => [12,  22,31,32,41,42,51,52], 'eating' => [21, 31,32,41,52,61,62,71]],
      ['pattern' => [7, 2, 0], 'cooking' => [11,12,  22,31,32,41,42,51,52], 'eating' => [12,21, 31,32,41,52,61,62,71]],
      ['pattern' => [7, 3, 0], 'cooking' => [11,12,82,  22,31,32,41,42,51,52], 'eating' => [12,21,81, 31,32,41,52,61,62,71]],
      ['pattern' => [7, 4, 0], 'cooking' => [11,12,81,82,  22,31,32,41,42,51,52], 'eating' => [12,21,72,81, 31,32,41,42,51,52,61]],
      ['pattern' => [7, 5, 0], 'cooking' => [11,12,81,82,21,  31,32,41,42,51,52,61], 'eating' => [11,12,81,82,21, 31,32,41,42,51,52,61]],
      ['pattern' => [8, 1, 0], 'cooking' => [11,  21,22,31,32,41,42,51,52], 'eating' => [12, 32,41,43,45,52,61,62,71]],
      ['pattern' => [8, 2, 0], 'cooking' => [11,12,  21,22,31,32,41,42,51,52], 'eating' => [12,21, 32,41,43,45,52,61,62,71]],
      ['pattern' => [8, 3, 0], 'cooking' => [11,12,82,  21,22,31,32,41,42,51,52], 'eating' => [12,21,81, 32,41,43,45,52,61,62,71]],
      ['pattern' => [8, 4, 0], 'cooking' => [11,12,81,82,  21,22,31,32,41,42,51,52], 'eating' => [12,21,72,81, 31,32,41,42,51,52,61,62]],
      ['pattern' => [9, 1, 0], 'cooking' => [11,  21,22,31,32,41,42,51,52,61], 'eating' => [12, 31,32,41,43,45,52,61,62,71]],
      ['pattern' => [9, 2, 0], 'cooking' => [11,12,  21,22,31,32,41,42,51,52,61], 'eating' => [12,21, 31,32,41,43,45,52,61,62,71]],
      ['pattern' => [9, 3, 0], 'cooking' => [11,12,82,  21,22,31,32,41,42,51,52,61], 'eating' => [12,21,81, 31,32,41,43,45,52,61,62,71]],
      ['pattern' => [10, 1, 0], 'cooking' => [81,  11,12,21,22,31,32,41,42,51,52], 'eating' => [81, 22,31,32,41,43,45,52,61,62,71]],
      ['pattern' => [10, 2, 0], 'cooking' => [81,82,  11,12,21,22,31,32,41,42,51,52], 'eating' => [81,82, 22,31,32,41,43,45,52,61,62,71]],
      ['pattern' => [11, 1, 0], 'cooking' => [], 'eating' => []],

      // combinations of 3 groups
      ['pattern' => [1, 1, 1], 'cooking' => [21,  31,  41], 'eating' => [21,  62,  41]],
      ['pattern' => [2, 1, 1], 'cooking' => [21,  31,  41,42], 'eating' => [21,  32,41,  62]],
      ['pattern' => [2, 2, 1], 'cooking' => [11,12,  31,  41,42], 'eating' => [12,21,  32,41,  62]],
      ['pattern' => [2, 2, 2], 'cooking' => [11,12,  31,32,  41,42], 'eating' => [12,21,  32,41,  62,71]],
      ['pattern' => [3, 1, 1], 'cooking' => [12,  22,  32,41,42], 'eating' => [21,  32,41,52,  62]],
      ['pattern' => [3, 2, 1], 'cooking' => [11,12,  22,  32,41,42], 'eating' => [12,21,  32,  41,52,62]],
      ['pattern' => [3, 2, 2], 'cooking' => [11,12,  31,22,  41,42,51], 'eating' => [12,21,  32,41,52,  62,71]],
      ['pattern' => [3, 3, 1], 'cooking' => [11,12,82,  31,  41,42,51], 'eating' => [12,21,81,  32,41,52,  62]],
      ['pattern' => [3, 3, 2], 'cooking' => [11,12,82,  31,32,  41,42,51], 'eating' => [12,21,81,  32,41,52,  62,71]],
      ['pattern' => [3, 3, 3], 'cooking' => [11,12,82,  22,31,32,  41,42,51], 'eating' => [12,21,81,  41,42,51,  31,62,71]],
      ['pattern' => [4, 1, 1], 'cooking' => [12,  22,  41,42,51,52], 'eating' => [21,  62,  41,42,51,52]],
      ['pattern' => [4, 2, 1], 'cooking' => [11,12,  22,  31,32,41,42], 'eating' => [12,21,  62,  41,42,51,52]],
      ['pattern' => [4, 2, 2], 'cooking' => [11,12, 31,32,  41,42,51,52], 'eating' => [12,21,  62,71,  41,42,51,52]],
      ['pattern' => [4, 3, 1], 'cooking' => [11,12,21, 31,  41,42,51,52], 'eating' => [12,21,81,  62,  41,42,51,52]],
      ['pattern' => [4, 3, 2], 'cooking' => [11,12,21, 31,32,  41,42,51,52], 'eating' => [12,21,81,  62,71,  41,42,51,52]],
      ['pattern' => [4, 3, 3], 'cooking' => [11,12,82, 22,31,32,  41,42,51,52], 'eating' => [12,21,81,  62,71,31,  41,42,51,52]],
      ['pattern' => [4, 4, 1], 'cooking' => [11,12,21,22, 31,  41,42,51,52], 'eating' => [12,21,72,81,  31,  41,42,51,52]],
      ['pattern' => [4, 4, 2], 'cooking' => [11,12,81,82,  21,22,  41,42,51,52], 'eating' => [11,12,81,82,  22,31,  41,42,51,52]],
      ['pattern' => [4, 4, 3], 'cooking' => [11,12,81,82,  21,22,31,  41,42,51,52], 'eating' => [11,12,81,82,  22,31,62,  41,42,51,52]],
      ['pattern' => [4, 4, 4], 'cooking' => [11,12,81,82,  21,22,31,32,  41,42,51,52], 'eating' => [11,12,81,82,  22,31,62,71,  41,42,51,52]],
      ['pattern' => [5, 1, 1], 'cooking' => [12,  22,  32,41,42,51,52], 'eating' => [21,  62,  32,41,42,51,52]],
      ['pattern' => [5, 2, 1], 'cooking' => [11,12,  22,  32,41,42,51,52], 'eating' => [12,21,  62,  32,41,42,51,52]],
      ['pattern' => [5, 2, 2], 'cooking' => [11,12,  21,22,  32,41,42,51,52], 'eating' => [12,21,  62,71,  32,41,42,51,52]],
      ['pattern' => [5, 3, 1], 'cooking' => [11,12,82,  22,  32,41,42,51,52], 'eating' => [12,21,81,  62,  32,41,42,51,52]],
      ['pattern' => [5, 3, 2], 'cooking' => [11,12,82,  21,22,  32,41,42,51,52], 'eating' => [12,21,81,  62,71,  32,41,42,51,52]],
      ['pattern' => [5, 3, 3], 'cooking' => [11,12,82,  21,22,31,  41,42,51,52,61], 'eating' => [11,12,82,  62,71,22,  32,41,42,51,52]],
      ['pattern' => [5, 4, 1], 'cooking' => [11,12,81,82,  22,  32,41,42,51,52], 'eating' => [12,21,72,81,  62,  32,41,42,51,52]],
      ['pattern' => [5, 4, 2], 'cooking' => [11,12,81,82,  21,22,  32,41,42,51,52], 'eating' => [11,12,81,82,  22,31,  41,42,51,52,61]],
      ['pattern' => [5, 4, 3], 'cooking' => [11,12,81,82,  21,22,31,  41,42,51,52,61], 'eating' => [11,12,81,82,  22,31,71,  41,42,51,52,61]],
      ['pattern' => [5, 4, 4], 'cooking' => [], 'eating' => []],
      ['pattern' => [5, 5, 1], 'cooking' => [11,12,21,81,82,  31,  41,42,51,52,61], 'eating' => [11,12,21,81,82,  31,  41,42,51,52,61]],
      ['pattern' => [5, 5, 2], 'cooking' => [11,12,21,81,82,  31,32,  41,42,51,52,61], 'eating' => [11,12,21,81,82,  22,31,  41,42,51,52,61]],
      ['pattern' => [5, 5, 3], 'cooking' => [], 'eating' => []],
      ['pattern' => [6, 1, 1], 'cooking' => [11,  21,  31,32,41,42,51,52], 'eating' => [21,  71,  32,41,43,45,52,61]],
      ['pattern' => [6, 2, 1], 'cooking' => [11,12,  22,  31,32,41,42,51,52], 'eating' => [12,21,  71,  32,41,43,45,52,61]],
      ['pattern' => [6, 2, 2], 'cooking' => [], 'eating' => []],
      ['pattern' => [6, 3, 1], 'cooking' => [11,12,82,  22,  31,32,41,42,51,52], 'eating' => [12,21,81,  71,  32,41,43,45,52,61]],
      ['pattern' => [6, 3, 2], 'cooking' => [11,12,82,  21,22,  31,32,41,42,51,52], 'eating' => [12,21,81,  62,71,  32,41,43,45,52,61]],
      ['pattern' => [6, 3, 3], 'cooking' => [], 'eating' => []],
      ['pattern' => [6, 4, 1], 'cooking' => [11,12,81,82,  22,  31,32,41,42,51,52], 'eating' => [11,12,81,82,  22,  32,41,43,45,52,61]],
      ['pattern' => [6, 4, 2], 'cooking' => [11,12,81,82,  21,22,  31,32,41,42,51,52], 'eating' => [11,12,81,82,  22,31,  32,41,43,45,52,61]],
      ['pattern' => [6, 4, 3], 'cooking' => [], 'eating' => []],
      ['pattern' => [6, 5, 1], 'cooking' => [11,12,21,81,82,   31,32,41,42,51,52,  61], 'eating' => [11,12,21,81,82,  32,41,43,45,52,61,  71]],
      ['pattern' => [6, 5, 2], 'cooking' => [], 'eating' => []],
      ['pattern' => [7, 1, 1], 'cooking' => [11,  21,  31,32,41,42,51,52,61], 'eating' => [21,  81,  31,32,41,43,45,52,61]],
      ['pattern' => [7, 2, 1], 'cooking' => [11,  21,22,  31,32,41,42,51,52,61], 'eating' => [11,  72,81,  31,32,41,43,45,52,61]],
      ['pattern' => [7, 2, 2], 'cooking' => [], 'eating' => []],
      ['pattern' => [8, 1, 1], 'cooking' => [12,  81,  21,22,31,32,41,42,51,52], 'eating' => [12,  82,  22,31,32,41,52,61,62,71]],
      ['pattern' => [8, 2, 1], 'cooking' => [11,12,  81,  21,22,31,32,41,42,51,52], 'eating' => [12,21,  82,  31,32,41,42,51,52,61,62]],
      ['pattern' => [8, 2, 2], 'cooking' => [], 'eating' => []],
      ['pattern' => [9, 1, 1], 'cooking' => [12,  81,  21,22,31,32,41,42,51,52,61], 'eating' => [12,  82,  22,31,32,41,44,52,61,62,71]],
      ['pattern' => [9, 2, 1], 'cooking' => [], 'eating' => []],
      ['pattern' => [10, 1, 1], 'cooking' => [], 'eating' => []],
      ];


  public static function get()
  {
    return collect([
      ['group1' => 0, 'group2' => 0, 'available' => 12],
      ['group1' => 1, 'group2' => 0, 'available' => 10],
      ['group1' => 1, 'group2' => 1, 'available' => 7],
      ['group1' => 2, 'group2' => 0, 'available' => 10],
      ['group1' => 2, 'group2' => 1, 'available' => 7],
      ['group1' => 2, 'group2' => 2, 'available' => 6],
      ['group1' => 3, 'group2' => 0, 'available' => 9],
      ['group1' => 3, 'group2' => 1, 'available' => 6],
      ['group1' => 3, 'group2' => 2, 'available' => 6],
      ['group1' => 3, 'group2' => 3, 'available' => 6],
      ['group1' => 4, 'group2' => 0, 'available' => 8],
      ['group1' => 4, 'group2' => 1, 'available' => 6],
      ['group1' => 4, 'group2' => 2, 'available' => 6],
      ['group1' => 4, 'group2' => 3, 'available' => 5],
      ['group1' => 4, 'group2' => 4, 'available' => 4],
      ['group1' => 5, 'group2' => 0, 'available' => 7],
      ['group1' => 5, 'group2' => 1, 'available' => 6],
      ['group1' => 5, 'group2' => 2, 'available' => 5],
      ['group1' => 5, 'group2' => 3, 'available' => 3],
      ['group1' => 5, 'group2' => 4, 'available' => 3],
      ['group1' => 5, 'group2' => 5, 'available' => 2],
      ['group1' => 6, 'group2' => 0, 'available' => 6],
      ['group1' => 6, 'group2' => 1, 'available' => 5],
      ['group1' => 6, 'group2' => 2, 'available' => 4],
      ['group1' => 6, 'group2' => 3, 'available' => 2],
      ['group1' => 6, 'group2' => 4, 'available' => 2],
      ['group1' => 6, 'group2' => 5, 'available' => 1],
      ['group1' => 6, 'group2' => 6, 'available' => 0],
      ['group1' => 7, 'group2' => 0, 'available' => 5],
      ['group1' => 7, 'group2' => 1, 'available' => 2],
      ['group1' => 7, 'group2' => 2, 'available' => 1],
      ['group1' => 7, 'group2' => 3, 'available' => 0],
      ['group1' => 7, 'group2' => 4, 'available' => 0],
      ['group1' => 7, 'group2' => 5, 'available' => 0],
      ['group1' => 8, 'group2' => 0, 'available' => 4],
      ['group1' => 8, 'group2' => 1, 'available' => 2],
      ['group1' => 8, 'group2' => 2, 'available' => 1],
      ['group1' => 8, 'group2' => 3, 'available' => 0],
      ['group1' => 8, 'group2' => 4, 'available' => 0],
      ['group1' => 9, 'group2' => 0, 'available' => 3],
      ['group1' => 9, 'group2' => 1, 'available' => 1],
      ['group1' => 9, 'group2' => 2, 'available' => 0],
      ['group1' => 9, 'group2' => 3, 'available' => 0],
      ['group1' => 10, 'group2' => 0, 'available' => 2],
      ['group1' => 10, 'group2' => 1, 'available' => 0],
      ['group1' => 10, 'group2' => 2, 'available' => 0],
      ['group1' => 11, 'group2' => 0, 'available' => 0],
      ['group1' => 11, 'group2' => 1, 'available' => 0]
   	]);
 }

  public static function seats($groups)
  {

    $three_first_groups = array_slice($groups, 0, 3);
    $aux = collect(self::seatsArray);
    $arrangement = $aux->first(function ($item) use ($three_first_groups) {
            return ($item['pattern'] == $three_first_groups); } );
    if (!$arrangement) {
      return ['cooking' => [], 'eating' => [] ];
    } else {
      return $arrangement;
    }
  }
}

<?php

namespace App;

class CovidLayout
{

  public static function get()
  {
    return collect([
      ['group1' => 0, 'group2' => 0, 'available' => 12],
      ['group1' => 1, 'group2' => 0, 'available' => 9],
      ['group1' => 1, 'group2' => 1, 'available' => 5],
      ['group1' => 2, 'group2' => 0, 'available' => 8],
      ['group1' => 2, 'group2' => 1, 'available' => 5],
      ['group1' => 2, 'group2' => 2, 'available' => 3],
      ['group1' => 3, 'group2' => 0, 'available' => 6],
      ['group1' => 3, 'group2' => 1, 'available' => 2],
      ['group1' => 3, 'group2' => 2, 'available' => 2],
      ['group1' => 4, 'group2' => 0, 'available' => 6],
      ['group1' => 5, 'group2' => 0, 'available' => 4],
      ['group1' => 6, 'group2' => 0, 'available' => 4],
      ['group1' => 7, 'group2' => 0, 'available' => 2],
      ['group1' => 8, 'group2' => 0, 'available' => 1],
  	]);
 }

  public static function seats($groups)
  {
    $seats = collect([
      ['pattern' => [2, 2, 1], 'cooking' => [11,12,  31,41,  42], 'eating' => [12,21,  32,41,  62]],
      ['pattern' => [2, 2, 2], 'cooking' => [11,12,  31,32,  41,42], 'eating' => [12,21,  32,41,  62,71]],
      ['pattern' => [3, 2, 1], 'cooking' => [11,12,  22,  32,41,42], 'eating' => [12,21,  32,  41,52,62]],
      ['pattern' => [3, 2, 2], 'cooking' => [11,12,82,  31,22,  42], 'eating' => [12,21,32,  41,52,  62,71]],

      ['pattern' => [6, 0, 0], 'cooking' => [21,22,31,32,41,42], 'eating' => [32,41,52,61,91,92]]
    ]);

    $three_first_groups = array_slice($groups, 0, 3);
    $arrangement = $seats->first(function ($item) use ($three_first_groups) {
            return ($item['pattern'] == $three_first_groups); } );
    if (!$arrangement) {
      return ['cooking' => [], 'eating' => [] ];
    } else {
      return $arrangement;
    }
  }
}

<?php

namespace App;

class CovidLayout
{

  public static function get()
  {
    return collect([
      ['group1' => 0, 'group2' => 0, 'available' => 12],
      ['group1' => 1, 'group2' => 0, 'available' => 8],
      ['group1' => 1, 'group2' => 1, 'available' => 4],
      ['group1' => 2, 'group2' => 0, 'available' => 7],
      ['group1' => 2, 'group2' => 1, 'available' => 3],
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
}

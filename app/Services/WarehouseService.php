<?php

namespace App\Services;

class WarehouseService
{
    public static function logisticDays($wh_id)
    {
        $logistic_days = [
          1 => 0,
          232 => 0,
          9 => 3,
          3 => 4,
          18 => 4,
          825 => 6,
          4 => 7,
          443 => 2,
          755 => 3,
          154 => 3,
          73 => 3,
          846 => 3,
          115 => 3,
          766 => 3,
          46 => 4,
          313 => 4,
          57 => 4,
          22 => 5,
          689 => 5,
          853 => 5,
          43 => 5,
          865 => 6,
          42 => 7,
          562 => 8
        ];
        return $logistic_days[$wh_id] ?? '7-10';
    }
}

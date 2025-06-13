<?php

namespace App;

use App\Enum\VehicleEnum;

class VehicleFactory
{
    public static function create(VehicleEnum $type, int $duration, float $price): Vehicle
    {
        return new Vehicle($type, $duration, $price);
    }

    public static function getPrice(VehicleEnum $type): float
    {
        return $type->getPrice();
    }
}

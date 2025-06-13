<?php

require_once 'Vehicle.php';
require_once 'Enum/VehicleEnum.php';

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

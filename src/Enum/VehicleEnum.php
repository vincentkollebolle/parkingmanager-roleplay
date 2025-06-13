<?php

namespace App\Enum;

enum VehicleEnum: string
{
    case CAR = 'car';
    case TRUCK = 'truck';
    case MOTO = 'moto';
    case BIKE = 'bike';

    public function getCO2(): float
    {
        return match ($this) {
            self::CAR => 3.5,
            self::TRUCK => 6.0,
            self::MOTO => 1.0,
            self::BIKE => 0.0,
        };
    }

    public function getPrice(): float
    {
        return match ($this) {
            self::CAR => 2.0,
            self::TRUCK => 3.5,
            self::MOTO => 1.5,
            self::BIKE => 0.5,
        };
    }
}

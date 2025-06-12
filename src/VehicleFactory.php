<?php
require_once 'Vehicle.php';

class VehicleFactory {
    public static function create($type, $duration, $price): Vehicle {
        return new Vehicle($type, $duration, $price);
    }

    public static function getPrice($type): float {
        return match($type) {
            'car' => 2.0,
            'electric' => 1.5,
            'truck' => 3.5,
            'bike' => 0.5,
            default => 1.0
        };
    }
}

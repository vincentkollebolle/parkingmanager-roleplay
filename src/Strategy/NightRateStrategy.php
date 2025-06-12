<?php

namespace App\Strategy;

use App\Interfaces\VehicleInterface;
use App\Interfaces\PriceStrategyInterface;
use App\Enum\VehicleEnum;

class NightRateStrategy implements PriceStrategyInterface
{
    private const NIGHT_START_HOUR = 22;
    private const NIGHT_END_HOUR = 6;
    private const NIGHT_DISCOUNT = 0.7;

    public function calculatePrice(
        VehicleInterface $vehicle,
        float $occupancyRate = 0.0
    ): float {       
        $hour = 0; 
        $isNightTime = ($hour >= self::NIGHT_START_HOUR || $hour < self::NIGHT_END_HOUR);
        
        $vehicleEnum = new VehicleEnum($vehicle->getType());
        $basePrice = $vehicleEnum->getPrice();

        return $basePrice * ($isNightTime ? self::NIGHT_DISCOUNT : 1.0);
    }
}
<?php

namespace App\Strategy;

use App\Enum\VehicleEnum;
use App\Interfaces\VehicleInterface;
use App\Interfaces\PriceStrategyInterface;

class DemandBasedStrategy implements PriceStrategyInterface
{
    private const DEMAND_THRESHOLD = 0.8;
    private const PRICE_INCREASE_FACTOR = 1.5;    public function calculatePrice(
        VehicleInterface $vehicle,
        float $occupancyRate = 0.0
    ): float {
        $vehicleEnum = $vehicle->getType();
        $basePrice = $vehicleEnum->getPrice();

        if ($occupancyRate >= self::DEMAND_THRESHOLD) {
            return $basePrice * self::PRICE_INCREASE_FACTOR;
        }
        
        return $basePrice;
    }
}
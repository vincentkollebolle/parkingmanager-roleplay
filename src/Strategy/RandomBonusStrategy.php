<?php

namespace App\Strategy;

use App\Interfaces\VehicleInterface;
use App\Interfaces\PriceStrategyInterface;
use App\Enum\VehicleEnum;

class RandomBonusStrategy implements PriceStrategyInterface
{
    private const BONUS_PROBABILITY = 0.1; // 1 véhicule sur 10
    private const DISCOUNT_RATE = 0.8; // 20% de réduction

    public function calculatePrice(
        VehicleInterface $vehicle,
        float $occupancyRate = 0.0
    ): float {
        $vehicleEnum = new VehicleEnum($vehicle->getType());
        $basePrice = $vehicleEnum->getPrice();
        
        $hasBonus = (mt_rand() / mt_getrandmax()) < self::BONUS_PROBABILITY;
        
        if ($hasBonus) {
            return $basePrice * self::DISCOUNT_RATE;
        }
        
        return $basePrice;
    }
}

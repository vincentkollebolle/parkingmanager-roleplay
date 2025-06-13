<?php

namespace App\Strategy;

use App\Interfaces\VehicleInterface;
use App\Interfaces\PriceStrategyInterface;
use App\Enum\VehicleEnum;

class EcoFriendlyDiscountStrategy implements PriceStrategyInterface
{
    private const ECO_DISCOUNT = 0.8; // 20% de réduction pour les véhicules écologiques
    private const ECO_VEHICLES = ['bike']; // Véhicules considérés comme écologiques

    public function calculatePrice(
        VehicleInterface $vehicle,
        float $occupancyRate = 0.0
    ): float {
        
        $vehicleEnum = $vehicle->getType();
        $basePrice = $vehicleEnum->getPrice();
        
        // Applique une réduction pour les véhicules écologiques (faible émission CO2)
        $isEcoFriendly = $vehicle->getCO2() == 0.0 || in_array($vehicle->getType(), self::ECO_VEHICLES);
        
        if ($isEcoFriendly) {
            return $basePrice * self::ECO_DISCOUNT;
        }
        
        return $basePrice;
    }
}

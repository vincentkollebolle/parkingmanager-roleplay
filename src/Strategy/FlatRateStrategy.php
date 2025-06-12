<?php

namespace App\Strategy;

use App\Interfaces\VehicleInterface;
use App\Interfaces\PriceStrategyInterface;

class FlatRateStrategy implements PriceStrategyInterface
{
    private const RATES = [
        'car' => 10.0,    // Prix fixe par tick pour une voiture
        'truck' => 25.0,  // Prix fixe par tick pour un camion
        'moto' => 7.0,    // Prix fixe par tick pour une moto
        'bike' => 2.0     // Prix fixe par tick pour un vélo
    ];    /**
     * Calcule le prix fixe selon le type de véhicule
     *
     * @param VehicleInterface $vehicle Le véhicule à tarifer
     * @param float $occupancyRate Le taux d'occupation (non utilisé dans cette stratégie)
     * @return float Le prix par tick
     * @throws \InvalidArgumentException Si le type de véhicule n'est pas reconnu
     */
    public function calculatePrice(
        VehicleInterface $vehicle,
        float $occupancyRate = 0.0
    ): float {
        $vehicleType = $vehicle->getType();
        
        if (!isset(self::RATES[$vehicleType])) {
            throw new \InvalidArgumentException(
                "Type de véhicule non supporté: {$vehicleType}"
            );
        }

        return self::RATES[$vehicleType];
    }
}
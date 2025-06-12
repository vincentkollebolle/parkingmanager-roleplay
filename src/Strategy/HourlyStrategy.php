<?php

namespace App\Strategy;

use App\Interfaces\VehicleInterface;
use App\Interfaces\PriceStrategyInterface;
use App\Enum\VehicleEnum;

class HourlyStrategy implements PriceStrategyInterface
{
    /**
     * Définition des tranches horaires et des multiplicateurs de prix
     * Format: [heures => multiplicateur]
     */
    private const HOUR_RATES = [
        1 => 1.0,    // Première heure : prix normal
        3 => 0.9,    // 2-3 heures : -10%
        8 => 0.8,    // 4-8 heures : -20%
        24 => 0.7,   // 9-24 heures : -30%
        48 => 0.6    // >24 heures : -40%
    ];    /**
     * Calcule le prix selon la durée de stationnement prévue
     */
    public function calculatePrice(
        VehicleInterface $vehicle,
        float $occupancyRate = 0.0
    ): float {
        $duration = $vehicle->getWantedDuration();
        
        $vehicleEnum = new VehicleEnum($vehicle->getType());
        $basePrice = $vehicleEnum->getPrice();
        
        // Trouve le multiplicateur approprié selon la durée
        $rateMultiplier = $this->getRateMultiplier($duration);
        
        return $basePrice * $rateMultiplier;
    }

    /**
     * Détermine le multiplicateur de prix selon la durée
     */
    private function getRateMultiplier(int $duration): float
    {
        $lastRate = 0.5; // Taux par défaut pour très longue durée

        foreach (self::HOUR_RATES as $hours => $rate) {
            if ($duration <= $hours) {
                return $rate;
            }
        }

        return $lastRate;
    }
}
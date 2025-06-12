<?php

namespace App\Interfaces;

interface PriceStrategyInterface
{
    /**
     * Calcule le prix pour un véhicule donné
     *
     * @param VehicleInterface $vehicle Le véhicule à tarifer
     * @param float $occupancyRate Le taux d'occupation du parking (0.0 à 1.0)
     * @return float Le prix par tick
     */
    public function calculatePrice(
        VehicleInterface $vehicle,
        float $occupancyRate = 0.0
    ): float;
}

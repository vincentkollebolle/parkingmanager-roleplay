<?php

namespace App;

use App\Interfaces\PriceStrategyInterface;
use App\Interfaces\VehicleInterface;

class PriceManager
{
    private PriceStrategyInterface $strategy;

    public function __construct(PriceStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * Change la stratégie de tarification
     */
    public function setStrategy(PriceStrategyInterface $strategy): void
    {
        $this->strategy = $strategy;
    }

    /**
     * Calcule le prix pour un véhicule avec la stratégie actuelle
     */
    public function calculatePrice(VehicleInterface $vehicle, float $occupancyRate = 0.0): float
    {
        return $this->strategy->calculatePrice($vehicle, $occupancyRate);
    }

    /**
     * Retourne le nom de la stratégie actuellement utilisée
     */
    public function getStrategyName(): string
    {
        return get_class($this->strategy);
    }
}

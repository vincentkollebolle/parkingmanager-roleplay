<?php

namespace App\Tracker;

use App\Vehicle;
use App\Interfaces\ObserverInterface;

class CO2Tracker implements ObserverInterface
{
    private $carEmission = 0;
    private $allCarEmission = 0;

    public function addRejected(Vehicle $vehicle)
    {
        // passe par VehicleFactory puis creer vehicule
        $this->carEmission += $vehicle->getCO2();
        $this->allCarEmission++;
    }

    public function onTick(int $tick): void
    {
        // CO2 tracking happens when vehicles are processed, not on tick
    }

    public function getReport(): array
    {
        return [
            "totalEmittedWhileWaiting" => round($this->carEmission, 1),
            "averageEmissionPerRejectedVehicle" => $this->allCarEmission ? round($this->carEmission / $this->allCarEmission, 1) : 0
        ];
    }
}

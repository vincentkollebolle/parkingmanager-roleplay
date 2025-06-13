<?php

namespace App\Tracker;

use App\Vehicle;

class CO2Tracker
{
    private $carEmission = 0;
    private $allCarEmission = 0;

    public function addRejectedCO2(Vehicle $vehicle)
    {
        // passe par VehicleFactory puis creer vehicule
        $this->carEmission += $vehicle->getCO2();
        $this->allCarEmission++;
    }
    public function getReport(): array
    {
        return [
            "totalEmittedWhileWaiting" => round($this->carEmission, 1),
            "averageEmissionPerRejectedVehicle" => $this->allCarEmission ? round($this->carEmission / $this->allCarEmission, 1) : 0
        ];
    }
}

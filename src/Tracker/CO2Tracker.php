<?php
class CO2Tracker {
    private $totalEmission = 0;
    private $rejectedVehicles = 0;

    public function addRejected($vehicle) {
        $this->totalEmission += $vehicle->getCO2();
        $this->rejectedVehicles++;
    }

    public function onTick($tick) {}

    public function getReport(): array {
        return [
            "totalEmittedWhileWaiting" => round($this->totalEmission, 1),
            "averageEmissionPerRejectedVehicle" => $this->rejectedVehicles ? round($this->totalEmission / $this->rejectedVehicles, 1) : 0
        ];
    }
}

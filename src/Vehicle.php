<?php
require_once 'Interface/VehicleInterface.php';

class Vehicle implements VehicleInterface {
    private $type;
    private $duration;
    private $maxPrice;

    public function __construct($type, $duration, $maxPrice) {
        $this->type = $type;
        $this->duration = $duration;
        $this->maxPrice = $maxPrice;
    }

    public function getType(): string {
        return $this->type;
    }

    public function getWantedDuration(): int {
        return $this->duration;
    }

    public function getMaxPricePerTick(): float {
        return $this->maxPrice;
    }

    public function getCO2(): float {
        return match($this->type) {
            'car' => 3.5,
            'truck' => 6.0,
            'moto' => 1.0,
            'bike' => 0.0,
            default => 2.0
        };
    }
}

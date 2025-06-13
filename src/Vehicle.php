<?php

namespace App;

use App\Enum\VehicleEnum;
use App\Interface\VehicleInterface;

class Vehicle implements VehicleInterface
{
    private VehicleEnum $type;
    private int $duration;
    private float $maxPrice;

    public function __construct(VehicleEnum $type, int $duration, float $maxPrice)
    {
        $this->type = $type;
        $this->duration = $duration;
        $this->maxPrice = $maxPrice;
    }

    public function getType(): string
    {
        return $this->type->value;
    }

    public function getWantedDuration(): int
    {
        return $this->duration;
    }

    public function getMaxPricePerTick(): float
    {
        return $this->maxPrice;
    }

    public function getCO2(): float
    {
        return $this->type->getCO2();
    }
}

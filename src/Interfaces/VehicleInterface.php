<?php

namespace App\Interfaces;

use App\Enum\VehicleEnum;

interface VehicleInterface
{
    public function getType(): VehicleEnum;
    public function getWantedDuration(): int;
    public function getMaxPricePerTick(): float;
    public function getCO2(): float;
}

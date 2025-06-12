<?php
interface VehicleInterface {
    public function getType(): string;
    public function getWantedDuration(): int;
    public function getMaxPricePerTick(): float;
    public function getCO2(): float;
}

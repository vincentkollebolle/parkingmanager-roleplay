<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Vehicle;
use App\Enum\VehicleEnum;

class VehicleTest extends TestCase
{
    public function testGetTypeReturnsEnumValue()
    {
        $vehicle = new Vehicle(VehicleEnum::CAR, 5, 10.0);
        $this->assertEquals('car', $vehicle->getType());
    }

    public function testGetWantedDurationReturnsDuration()
    {
        $vehicle = new Vehicle(VehicleEnum::TRUCK, 7, 20.0);
        $this->assertEquals(7, $vehicle->getWantedDuration());
    }

    public function testGetMaxPricePerTickReturnsMaxPrice()
    {
        $vehicle = new Vehicle(VehicleEnum::MOTO, 3, 15.5);
        $this->assertEquals(15.5, $vehicle->getMaxPricePerTick());
    }

    public function testGetCO2ReturnsEnumCO2()
    {
        $vehicle = new Vehicle(VehicleEnum::BIKE, 2, 5.0);
        $this->assertEquals(0.0, $vehicle->getCO2());
        $vehicle2 = new Vehicle(VehicleEnum::TRUCK, 2, 5.0);
        $this->assertEquals(6.0, $vehicle2->getCO2());
    }
}

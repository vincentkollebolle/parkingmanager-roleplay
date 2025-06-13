<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Vehicle;
use App\Enum\VehicleEnum;

class VehicleTest extends TestCase
{
    public function testVehicleCreation(): void
    {
        $type = VehicleEnum::from('car');
        $duration = 5;
        $maxPrice = 10.0;
        
        $vehicle = new Vehicle($type, $duration, $maxPrice);
        
        $this->assertSame($type, $vehicle->getType());
        $this->assertEquals($duration, $vehicle->getWantedDuration());
        $this->assertEquals($maxPrice, $vehicle->getMaxPricePerTick());
        $this->assertEquals($type->getCO2(), $vehicle->getCO2());
    }

    public function testVehicleTypeCO2Emissions(): void
    {
        $vehicle = new Vehicle(VehicleEnum::from('car'), 1, 10.0);
        $this->assertEquals(3.5, $vehicle->getCO2());

        $vehicle = new Vehicle(VehicleEnum::from('bike'), 1, 10.0);
        $this->assertEquals(0.0, $vehicle->getCO2());
    }
}

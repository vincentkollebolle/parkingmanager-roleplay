<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\VehicleFactory;
use App\Vehicle;
use App\Enum\VehicleEnum;

class VehicleFactoryTest extends TestCase
{
    public function testCreateVehicle(): void
    {
        $type = VehicleEnum::from('car');
        $duration = 5;
        $price = 10.0;

        $vehicle = VehicleFactory::create($type, $duration, $price);

        $this->assertInstanceOf(Vehicle::class, $vehicle);
        $this->assertEquals($type, $vehicle->getType());
        $this->assertEquals($duration, $vehicle->getWantedDuration());
        $this->assertEquals($price, $vehicle->getMaxPricePerTick());
    }

    public function testCreateAllVehicleTypes(string $type): void
    {
        $vehicleEnum = VehicleEnum::from($type);
        $vehicle = VehicleFactory::create($vehicleEnum, 1, 10.0);

        $this->assertInstanceOf(Vehicle::class, $vehicle);
        $this->assertEquals($vehicleEnum, $vehicle->getType());
    }

    public static function vehicleTypesProvider(): array
    {
        return [
            ['car'],
            ['truck'],
            ['moto'],
            ['bike']
        ];
    }
}

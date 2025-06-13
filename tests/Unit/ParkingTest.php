<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Parking;
use App\Vehicle;
use App\Enum\VehicleEnum;

class ParkingTest extends TestCase
{
    private Parking $parking;

    protected function setUp(): void
    {
        $this->parking = Parking::getInstance(10); // Small size for testing
    }

    protected function tearDown(): void
    {
        $reflection = new \ReflectionClass(Parking::class);
        $instance = $reflection->getProperty('instance');
        $instance->setValue(null, null);
    }

    public function testSingleton(): void
    {
        $parking1 = Parking::getInstance(10);
        $parking2 = Parking::getInstance(20); // Different size should not matter
        
        $this->assertSame($parking1, $parking2);
    }

    public function testParkVehicle(): void
    {
        $vehicle = new Vehicle(VehicleEnum::from('car'), 2, 10.0);
        $this->parking->parkVehicle($vehicle);

        $stats = $this->parking->getTrafficStats();
        $this->assertEquals(1, $stats['totalVehiclesGenerated']);
        $this->assertEquals(1, $stats['totalVehiclesParked']);
    }

    public function testParkingFullRejection(): void
    {
        // Reset parking state
        $reflection = new \ReflectionClass(Parking::class);
        $vehiclesProperty = $reflection->getProperty('vehicles');
        $vehiclesProperty->setAccessible(true);
        $vehiclesProperty->setValue($this->parking, []);
        
        // Fill the parking
        for ($i = 0; $i < 10; $i++) {
            $vehicle = new Vehicle(VehicleEnum::from('car'), 2, 10.0);
            $this->parking->parkVehicle($vehicle);
        }

        // Try to park one more
        $extraVehicle = new Vehicle(VehicleEnum::from('car'), 2, 10.0);
        $this->parking->parkVehicle($extraVehicle);

        $stats = $this->parking->getTrafficStats();
        $this->assertEquals(11, $stats['totalVehiclesGenerated']);
        $this->assertEquals(10, $stats['totalVehiclesParked']);
        $this->assertEquals(1, $stats['totalVehiclesRejected']);
    }

    public function testVehicleTypeStats(): void
    {
        $carVehicle = new Vehicle(VehicleEnum::from('car'), 2, 10.0);
        $bikeVehicle = new Vehicle(VehicleEnum::from('bike'), 1, 5.0);
        
        $this->parking->parkVehicle($carVehicle);
        $this->parking->parkVehicle($bikeVehicle);

        $stats = $this->parking->getVehicleTypeStats();
        $this->assertArrayHasKey('car', $stats);
        $this->assertArrayHasKey('bike', $stats);
        $this->assertEquals(1, $stats['car']['parked']);
        $this->assertEquals(1, $stats['bike']['parked']);
    }
}

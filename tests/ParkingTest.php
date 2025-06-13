<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Parking;
use App\Vehicle;
use App\Enum\VehicleEnum;

class ParkingTest extends TestCase
{
    protected function setUp(): void
    {
        $ref = new \ReflectionProperty(Parking::class, 'instance');
        $ref->setAccessible(true);
        $ref->setValue(null, null);
    }

    public function testParkVehicleIncrementsStatsAndStoresVehicle()
    {
        $parking = Parking::getInstance(2);
        $vehicle = $this->createMock(Vehicle::class);
        $vehicle->method('getType')->willReturn('car');
        $parking->parkVehicle($vehicle);
        $stats = $parking->getTrafficStats();
        $this->assertEquals(1, $stats['totalVehiclesGenerated']);
        $this->assertEquals(1, $stats['totalVehiclesParked']);
        $this->assertEquals(0, $stats['totalVehiclesRejected']);
        $typeStats = $parking->getVehicleTypeStats();
        $this->assertEquals(1, $typeStats['car']['parked']);
        $this->assertEquals(0, $typeStats['car']['rejected']);
    }

    public function testRejectVehicleIncrementsStats()
    {
        $parking = Parking::getInstance(1);
        $vehicle = $this->createMock(Vehicle::class);
        $vehicle->method('getType')->willReturn('truck');
        $parking->parkVehicle($vehicle);
        $vehicle2 = $this->createMock(Vehicle::class);
        $vehicle2->method('getType')->willReturn('truck');
        $parking->parkVehicle($vehicle2);
        $stats = $parking->getTrafficStats();
        $this->assertEquals(3, $stats['totalVehiclesGenerated']);
        $this->assertEquals(1, $stats['totalVehiclesParked']);
        $this->assertEquals(1, $stats['totalVehiclesRejected']);
        $typeStats = $parking->getVehicleTypeStats();
        $this->assertEquals(1, $typeStats['truck']['parked']);
        $this->assertEquals(1, $typeStats['truck']['rejected']);
    }
}

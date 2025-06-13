<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Vehicle;
use App\Enum\VehicleEnum;
use App\Tracker\CO2Tracker;
use App\Tracker\IncomeTracker;

class TrackersTest extends TestCase
{
    public function testCO2TrackerReporting(): void
    {
        $tracker = new CO2Tracker();
        
        $car = new Vehicle(VehicleEnum::from('car'), 1, 10.0);   
        $truck = new Vehicle(VehicleEnum::from('truck'), 1, 15.0);
        $moto = new Vehicle(VehicleEnum::from('moto'), 1, 5.0);   
        
        $tracker->addRejected($car);
        $tracker->addRejected($truck);
        $tracker->addRejected($moto);
        
        $report = $tracker->getReport();
        
        $this->assertEquals(10.5, $report['totalEmittedWhileWaiting']);
        $this->assertEquals(3.5, $report['averageEmissionPerRejectedVehicle']);
    }

    public function testIncomeTrackerReporting(): void
    {
        $tracker = new IncomeTracker();
        
        $tracker->addRevenue(100.0);
        $tracker->addRevenue(50.0);
        $tracker->addLost(25.0);
        
        $report = $tracker->getReport();
        
        $this->assertEquals(150.0, $report['moneyEarn']);
        $this->assertEquals(25.0, $report['lossOfEarning']);
    }
}

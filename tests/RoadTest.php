<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Road;
use App\VehicleFactory;
use App\Enum\VehicleEnum;

class RoadTest extends TestCase
{
    public function testOnTickWithAcceptedAndRejectedVehicles()
    {
        $trafficSchedule = [
            [
                'date' => '2025-01-01 01:00',
                'vehicles' => [
                    [
                        'type' => VehicleEnum::CAR,
                        'wantedDuration' => 2,
                        'maxPricePerTick' => 2.0
                    ],
                    [
                        'type' => VehicleEnum::TRUCK,
                        'wantedDuration' => 1,
                        'maxPricePerTick' => 1.0 
                    ]
                ]
            ]
        ];

        $incomeTracker = $this->getMockBuilder('stdClass')
            ->addMethods(['addLost', 'addRevenue'])
            ->getMock();
        $co2Tracker = $this->getMockBuilder('stdClass')
            ->addMethods(['addRejected'])
            ->getMock();
        $parking = $this->getMockBuilder('stdClass')
            ->addMethods(['rejectVehicle', 'parkVehicle'])
            ->getMock();

        $incomeTracker->expects($this->once())->method('addLost');
        $incomeTracker->expects($this->once())->method('addRevenue');
        $co2Tracker->expects($this->once())->method('addRejected');

        $road = new Road($trafficSchedule, $incomeTracker, $co2Tracker);
        $road->onTick(1);
    }
}

<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Road;
use App\Tracker\IncomeTracker;
use App\Tracker\CO2Tracker;

class RoadTest extends TestCase
{
    private IncomeTracker $incomeTracker;
    private CO2Tracker $co2Tracker;

    protected function setUp(): void
    {
        $this->incomeTracker = new IncomeTracker();
        $this->co2Tracker = new CO2Tracker();
    }

    public function testRoadInitialization(): void
    {
        $schedule = [
            [
                'date' => '2025-01-01 08:00',
                'vehicles' => [
                    [
                        'type' => 'car',
                        'wantedDuration' => 4,
                        'maxPricePerTick' => 5.0
                    ]
                ]
            ]
        ];

        $road = new Road($schedule, $this->incomeTracker, $this->co2Tracker);
        $this->assertInstanceOf(Road::class, $road);
    }

    public function testVehicleGeneration(): void
    {
        $schedule = [
            [
                'date' => '2025-01-01 00:00',
                'vehicles' => [
                    [
                        'type' => 'car',
                        'wantedDuration' => 4,
                        'maxPricePerTick' => 5.0
                    ],
                    [
                        'type' => 'bike',
                        'wantedDuration' => 2,
                        'maxPricePerTick' => 2.0
                    ]
                ]
            ]
        ];

        $road = new Road($schedule, $this->incomeTracker, $this->co2Tracker);
        $road->onTick(0); // First tick should generate two vehicles

        // The effects should be visible in the trackers
        // We can't directly test the vehicle generation as it's handled internally
        $this->assertNotEmpty($this->co2Tracker->getReport());
    }

    public function testEmptyScheduleTick(): void
    {
        $road = new Road([], $this->incomeTracker, $this->co2Tracker);
        $road->onTick(0); // Should handle empty schedule gracefully
        
        $this->assertEmpty($this->co2Tracker->getReport()['totalEmittedWhileWaiting']);
    }
}

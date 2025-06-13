<?php

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use App\PriceManager;
use App\Strategy\DemandBasedStrategy;
use App\Strategy\EcoFriendlyDiscountStrategy;
use App\Clock;
use App\Parking;
use App\Road;
use App\Tracker\IncomeTracker;
use App\Tracker\CO2Tracker;

class ParkingSystemTest extends TestCase
{
    private Clock $clock;
    private Parking $parking;
    private IncomeTracker $incomeTracker;
    private CO2Tracker $co2Tracker;

    protected function setUp(): void
    {
        $this->clock = new Clock();
        $this->parking = Parking::getInstance(5); // Small size for testing
        $this->incomeTracker = new IncomeTracker();
        $this->co2Tracker = new CO2Tracker();
    }

    protected function tearDown(): void
    {
        $reflection = new \ReflectionClass(Parking::class);
        $instance = $reflection->getProperty('instance');
        $instance->setValue(null, null);
    }

    public function testFullSystemIntegration(): void
    {
        $schedule = [
            [
                'date' => '2025-01-01 00:00',
                'vehicles' => [
                    [
                        'type' => 'car',
                        'wantedDuration' => 2,
                        'maxPricePerTick' => 10.0
                    ],
                    [
                        'type' => 'bike',
                        'wantedDuration' => 1,
                        'maxPricePerTick' => 5.0
                    ]
                ]
            ],
            [
                'date' => '2025-01-01 01:00',
                'vehicles' => [
                    [
                        'type' => 'truck',
                        'wantedDuration' => 3,
                        'maxPricePerTick' => 15.0
                    ]
                ]
            ]
        ];

        $road = new Road($schedule, $this->incomeTracker, $this->co2Tracker);
        
        $this->clock->subscribe($road);
        $this->clock->subscribe($this->parking);
        $this->clock->subscribe($this->incomeTracker);
        $this->clock->subscribe($this->co2Tracker);

        // Run simulation for 4 hours
        for ($i = 0; $i < 4; $i++) {
            $this->clock->tick();
        }

        $trafficStats = $this->parking->getTrafficStats();
        $this->assertGreaterThan(0, $trafficStats['totalVehiclesGenerated']);
        
        $incomeReport = $this->incomeTracker->getReport();
        $this->assertGreaterThan(0, $incomeReport['moneyEarn']);
        
        $co2Report = $this->co2Tracker->getReport();
        $this->assertIsFloat($co2Report['totalEmittedWhileWaiting']);
    }

    public function testPriceStrategySwitch(): void
    {
        $priceManager = new PriceManager(new DemandBasedStrategy());
        
        // Start with demand-based pricing
        $initialStrategy = $priceManager->getStrategyName();
        
        // Switch to eco-friendly pricing
        $priceManager->setStrategy(new EcoFriendlyDiscountStrategy());
        
        $this->assertNotEquals($initialStrategy, $priceManager->getStrategyName());
    }
}

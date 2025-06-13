<?php

namespace Tests\Performance;

use PHPUnit\Framework\TestCase;
use App\SimulationRunner;
use App\Parking;
use App\Clock;

class PerformanceTest extends TestCase
{
    protected function tearDown(): void
    {
        $reflection = new \ReflectionClass(Parking::class);
        $instance = $reflection->getProperty('instance');
        $instance->setValue(null, null);
    }

    public function testLargeScaleSimulation(): void
    {
        $schedule = [];
        
        // Create a large schedule with 1000 time slots
        for ($i = 0; $i < 1000; $i++) {
            $vehicles = [];
            $numVehicles = rand(1, 10);
            
            for ($j = 0; $j < $numVehicles; $j++) {
                $type = ['car', 'truck', 'moto', 'bike'][rand(0, 3)];
                $vehicles[] = [
                    'type' => $type,
                    'wantedDuration' => rand(1, 24),
                    'maxPricePerTick' => rand(5, 50) / 2
                ];
            }
            
            $schedule[] = [
                'date' => date('Y-m-d H:i', strtotime("2025-01-01 00:00 +{$i} hours")),
                'vehicles' => $vehicles
            ];
        }

        $startTime = microtime(true);
        
        $simulator = new SimulationRunner();
        $result = $simulator->run($schedule);
        
        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        // Assert simulation completed successfully
        $this->assertArrayHasKey('simulationName', $result);
        $this->assertArrayHasKey('parkingSize', $result);
        
        // Performance assertions
        $this->assertLessThan(
            10.0, // Maximum allowed execution time in seconds
            $executionTime,
            "Simulation took too long: {$executionTime} seconds"
        );

        // Memory usage check
        $memoryUsage = memory_get_peak_usage(true) / 1024 / 1024; // Convert to MB
        $this->assertLessThan(
            128, // Maximum allowed memory usage in MB
            $memoryUsage,
            "Simulation used too much memory: {$memoryUsage}MB"
        );
    }

    public function testConcurrentVehicleHandling(): void
    {
        $clock = new Clock();
        $parking = Parking::getInstance(1000);
        
        $startTime = microtime(true);
        
        // Simulate 100 ticks with multiple observers
        for ($i = 0; $i < 100; $i++) {
            $clock->tick();
        }
        
        $executionTime = microtime(true) - $startTime;
        
        $this->assertLessThan(
            1.0, // Maximum allowed execution time in seconds
            $executionTime,
            "Clock ticking took too long: {$executionTime} seconds"
        );
    }
}

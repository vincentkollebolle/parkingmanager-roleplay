<?php

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use App\SimulationRunner;

class SimulationRunnerTest extends TestCase
{
    private $sampleTrafficSchedule = [
        [
            "date" => "2025-01-01 08:00",
            "vehicles" => [
                [
                    "type" => "car",
                    "wantedDuration" => 4,
                    "maxPricePerTick" => 5.0
                ],
                [
                    "type" => "bike",
                    "wantedDuration" => 2,
                    "maxPricePerTick" => 2.0
                ]
            ]
        ],
        [
            "date" => "2025-01-01 09:00",
            "vehicles" => [
                [
                    "type" => "truck",
                    "wantedDuration" => 3,
                    "maxPricePerTick" => 8.0
                ]
            ]
        ]
    ];

    public function testFullSimulation(): void
    {
        $simulator = new SimulationRunner();
        $result = $simulator->run($this->sampleTrafficSchedule);

        // Test structure of result
        $this->assertArrayHasKey('simulationName', $result);
        $this->assertArrayHasKey('parkingSize', $result);
        $this->assertArrayHasKey('durationTicks', $result);
        $this->assertArrayHasKey('revenue', $result);
        $this->assertArrayHasKey('traffic', $result);
        $this->assertArrayHasKey('byVehicleType', $result);
        $this->assertArrayHasKey('co2', $result);

        // Test specific values
        $this->assertEquals(1000, $result['parkingSize']);
        $this->assertEquals(8760, $result['durationTicks']);

        // Test vehicle type stats
        $vehicleStats = $result['byVehicleType'];
        $this->assertArrayHasKey('car', $vehicleStats);
        $this->assertArrayHasKey('bike', $vehicleStats);
        $this->assertArrayHasKey('truck', $vehicleStats);
    }
}

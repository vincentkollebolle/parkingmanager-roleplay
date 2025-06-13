<?php

namespace App;

class SimulationRunner
{
    public function run(array $trafficSchedule): array
    {
        $parkingSize = 1000;
        $durationTicks = 8760;
        $clock = new Clock();
        $parking = Parking::getInstance($parkingSize);
        $incomeTracker = new IncomeTracker();
        $co2Tracker = new CO2Tracker();
        $route = new Route($trafficSchedule, $incomeTracker, $co2Tracker);

        $clock->subscribe($route);
        $clock->subscribe($parking);
        $clock->subscribe($incomeTracker);
        $clock->subscribe($co2Tracker);

        for ($i = 0; $i < $durationTicks; $i++) {
            $clock->tick();
        }

        return [
            "simulationName" => "ParkingManager_" . date("Y-m-d_H-i"),
            "parkingSize" => $parkingSize,
            "durationTicks" => $durationTicks,
            "revenue" => $incomeTracker->getReport(),
            "traffic" => $parking->getTrafficStats(),
            "byVehicleType" => $parking->getVehicleTypeStats(),
            "co2" => $co2Tracker->getReport()
        ];
    }
}

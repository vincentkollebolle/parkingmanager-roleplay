<?php

namespace App;

use App\Interfaces\ObserverInterface;
use App\VehicleFactory;
use App\Enum\VehicleEnum;

class Road implements ObserverInterface
{
    private $schedule = [];
    private $incomeTracker;
    private $co2Tracker;

    public function __construct(array $trafficSchedule, $incomeTracker, $co2Tracker)
    {
        foreach ($trafficSchedule as $entry) {
            $tick = (int)((strtotime($entry['date']) - strtotime("2025-01-01 00:00")) / 3600);
            $this->schedule[$tick] = $entry['vehicles'];
        }
        $this->incomeTracker = $incomeTracker;
        $this->co2Tracker = $co2Tracker;
    }

    public function onTick(int $tick): void
    {
        if (isset($this->schedule[$tick])) {
            foreach ($this->schedule[$tick] as $vehicleData) {
                $vehicleType = VehicleEnum::from($vehicleData['type']);
                $vehicle = VehicleFactory::create($vehicleType, $vehicleData['wantedDuration'], $vehicleData['maxPricePerTick']);
                if ($vehicle->getType()->getPrice() > $vehicle->getMaxPricePerTick()) {
                    $this->incomeTracker->addLost($vehicle->getType()->getPrice() * $vehicle->getWantedDuration());
                    $this->co2Tracker->addRejected($vehicle);
                    Parking::getInstance()->rejectVehicle($vehicle);
                } else {
                    $this->incomeTracker->addRevenue($vehicle->getType()->getPrice() * $vehicle->getWantedDuration());
                    Parking::getInstance()->parkVehicle($vehicle);
                }
            }
        }
    }
}

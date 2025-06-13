<?php

namespace App;

use App\Enum\VehicleEnum;
use App\Interfaces\ObserverInterface;

class Parking implements ObserverInterface {
    private static $instance = null;
    private $size;
    /**
     * @var Vehicle[]
     */
    private $vehicles = [];
    private $totalVehiclesGenerated = 0;    
    private $totalVehiclesParked = 0;
    private $totalVehiclesRejected = 0;
    private $stats = ['byType' => [

    ]];


    private function __construct($size) {
        $this->size = $size;
    }

    public static function getInstance($size = 1000): Parking {
        if (self::$instance === null) {
            self::$instance = new Parking($size);
        }
        return self::$instance;
    }

    public function onTick(int $tick): void {}

    public function parkVehicle($vehicle) {
        $type = $vehicle->getType()->value;
        $this->totalVehiclesGenerated++;

        if (!isset($this->stats['byType'][$type])) {
            $this->stats['byType'][$type] = ['parked' => 0, 'rejected' => 0];
        }

        if (count($this->vehicles) < $this->size) {
            $this->vehicles[] = $vehicle;
            $this->totalVehiclesParked++;
            $this->stats['byType'][$type]['parked']++;
        } else {
            $this->rejectVehicle($vehicle);
        }
    }

    public function rejectVehicle($vehicle) {
        $type = $vehicle->getType()->value;
        $this->totalVehiclesGenerated++;
        $this->totalVehiclesRejected++;
    
        if (!isset($this->stats['byType'][$type])) {
            $this->stats['byType'][$type] = ['parked' => 0, 'rejected' => 0];
        }
        
        $this->stats['byType'][$type]['rejected']++;
    }

    public function getTrafficStats(): array {
        return [
            "totalVehiclesGenerated" => $this->totalVehiclesGenerated,
            "totalVehiclesParked" => $this->totalVehiclesParked,
            "totalVehiclesRejected" => $this->totalVehiclesRejected,
        ];
    }

    public function getVehicleTypeStats(): array {
        $details = [];
        foreach ($this->stats['byType'] as $type => $data) {
            $details[$type] = array_merge([
                'parked' => 0,
                'rejected' => 0,
                'ticketPricePerHour' => VehicleEnum::from($type)->getPrice(),
            ], $data);
        }
        return $details;
    }
}

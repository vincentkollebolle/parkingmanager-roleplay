<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Vehicle;
use App\Enum\VehicleEnum;
use App\Strategy\DemandBasedStrategy;
use App\Strategy\EcoFriendlyDiscountStrategy;
use App\Strategy\FlatRateStrategy;

class PricingStrategiesTest extends TestCase
{
    public function testDemandBasedStrategy(): void
    {
        $strategy = new DemandBasedStrategy();
        $vehicle = new Vehicle(VehicleEnum::from('car'), 1, 10.0);
        
        $price = $strategy->calculatePrice($vehicle, 0.5);
        $this->assertEquals(2.0, $price); 
        
        $price = $strategy->calculatePrice($vehicle, 0.9);
        $this->assertEquals(3.0, $price); 
    }

    public function testEcoFriendlyStrategy(): void
    {
        $strategy = new EcoFriendlyDiscountStrategy();
        
        $bike = new Vehicle(VehicleEnum::from('bike'), 1, 10.0);
        $price = $strategy->calculatePrice($bike);
        $this->assertEquals(0.4, $price); 
        
        $car = new Vehicle(VehicleEnum::from('car'), 1, 10.0);
        $price = $strategy->calculatePrice($car);
        $this->assertEquals(2.0, $price); 
    }

    public function testFlatRateStrategy(): void
    {
        $strategy = new FlatRateStrategy();
        
        $car = new Vehicle(VehicleEnum::from('car'), 1, 20.0);
        $price = $strategy->calculatePrice($car);
        $this->assertEquals(10.0, $price);
        
        $bike = new Vehicle(VehicleEnum::from('bike'), 1, 5.0);
        $price = $strategy->calculatePrice($bike);
        $this->assertEquals(2.0, $price);
    }
}

<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Interfaces\VehicleInterface;
use ReflectionClass;

class VehicleInterfaceTest extends TestCase
{
    public function testInterfaceExists()
    {
        $this->assertTrue(interface_exists(VehicleInterface::class));
    }

    public function testInterfaceMethods()
    {
        $reflection = new ReflectionClass(VehicleInterface::class);
        $methods = array_map(fn($m) => $m->getName(), $reflection->getMethods());
        $this->assertContains('getType', $methods);
        $this->assertContains('getWantedDuration', $methods);
        $this->assertContains('getMaxPricePerTick', $methods);
        $this->assertContains('getCO2', $methods);
    }
}

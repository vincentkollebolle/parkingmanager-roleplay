<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Interfaces\ObserverInterface;
use App\Interfaces\ObserverInterface;

class ObserverInterfaceTest extends TestCase
{
    public function testInterfaceExists()
    {
        $this->assertTrue(interface_exists(ObserverInterface::class));
        $this->assertTrue(interface_exists(ObserverInterface::class));
    }
}

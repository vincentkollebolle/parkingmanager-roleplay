<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Clock;
use App\Interfaces\ObserverInterface;

class ClockTest extends TestCase
{
    public function testSubscribeAndTickCallsOnTick()
    {
        $observer = $this->createMock(ObserverInterface::class);
        $observer->expects($this->once())
                 ->method('onTick');

        $clock = new Clock();
        $clock->subscribe($observer);
        $clock->tick();
    }
}

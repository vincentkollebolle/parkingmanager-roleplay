<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Clock.php';
require_once __DIR__ . '/../src/Interface/ObserverInterface.php';

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

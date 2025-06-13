<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Clock;
use App\Interfaces\ObserverInterface;

class MockObserver implements ObserverInterface
{
    public $tickCount = 0;
    public $lastTick = -1;

    public function onTick(int $tick): void
    {
        $this->tickCount++;
        $this->lastTick = $tick;
    }
}

class ClockTest extends TestCase
{
    public function testClockNotifiesObservers(): void
    {
        $clock = new Clock();
        $observer1 = new MockObserver();
        $observer2 = new MockObserver();

        $clock->subscribe($observer1);
        $clock->subscribe($observer2);

        // Simulate 3 ticks
        for ($i = 0; $i < 3; $i++) {
            $clock->tick();
        }

        $this->assertEquals(3, $observer1->tickCount);
        $this->assertEquals(3, $observer2->tickCount);
        $this->assertEquals(2, $observer1->lastTick);
        $this->assertEquals(2, $observer2->lastTick);
    }

    public function testSingleTick(): void
    {
        $clock = new Clock();
        $observer = new MockObserver();
        
        $clock->subscribe($observer);
        $clock->tick();
        
        $this->assertEquals(1, $observer->tickCount);
        $this->assertEquals(0, $observer->lastTick);
    }

    public function testLateSubscription(): void
    {
        $clock = new Clock();
        $observer = new MockObserver();
        
        // Tick before subscribing
        $clock->tick();
        $clock->tick();
        
        $clock->subscribe($observer);
        $clock->tick();
        
        $this->assertEquals(1, $observer->tickCount);
        $this->assertEquals(2, $observer->lastTick);
    }
}

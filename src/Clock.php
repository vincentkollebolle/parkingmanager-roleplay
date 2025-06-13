<?php

namespace App;

use App\Interfaces\ObserverInterface;

class Clock
{
    /** @var ObserverInterface[] */
    private $observers = [];
    private $currentTick = 0;

    public function subscribe(ObserverInterface $observer)
    {
        $this->observers[] = $observer;
    }

    public function tick()
    {
        foreach ($this->observers as $observer) {
            $observer->onTick($this->currentTick);
        }
        $this->currentTick++;
    }
}

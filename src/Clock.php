<?php

namespace App;

use App\Interface\ObserverInterface;

class Clock
{
    /** @var ObserverInterface[] */
    private $observers = [];

    public function subscribe(ObserverInterface $observer)
    {
        $this->observers[] = $observer;
    }

    public function tick()
    {
        foreach ($this->observers as $observer) {
            $observer->onTick();
        }
    }
}

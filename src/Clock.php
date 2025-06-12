<?php
class Clock {
    private $tick = 0;
    private $duration;
    private $observers = [];

    public function __construct($duration) {
        $this->duration = $duration;
    }

    public function attach($observer) {
        $this->observers[] = $observer;
    }

    public function tick() {
        foreach ($this->observers as $observer) {
            if (method_exists($observer, 'onTick')) {
                $observer->onTick($this->tick);
            }
        }
        $this->tick++;
    }
}

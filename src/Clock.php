<?php
class Clock implements ObserverInterface
{
    private $tick = 0;
    private $observers = [];

    public function __construct()
    {
    
    }

    public function subscribe(ObserverInterface $observer): void
    {
        $this->observers[] = $observer;
    }

   public function onTick(int $tick): void
    {
        $this->tick = $tick;
        foreach ($this->observers as $observer) {
            $observer->onTick($this->tick);
        }
    }

    public function getTick(): int
    {
        return $this->tick;
    }
}

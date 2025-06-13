<?php

namespace App\Interfaces;

interface ObserverInterface
{
    public function onTick(int $tick);
}

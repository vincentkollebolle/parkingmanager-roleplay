<?php

namespace App\Tracker;

use App\Interfaces\ObserverInterface;

class IncomeTracker implements ObserverInterface
{
    private $moneyEarn = 0;
    private $lossOfEarning = 0;

    public function addRevenue($amount)
    {
        $this->moneyEarn += $amount;
    }

    public function addLost($amount)
    {
        $this->lossOfEarning += $amount;
    }

    public function onTick(int $tick): void {}

    public function getReport(): array
    {
        return [
            "moneyEarn" => $this->moneyEarn,
            "lossOfEarning" => $this->lossOfEarning
        ];
    }
}

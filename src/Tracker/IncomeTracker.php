<?php
class IncomeTracker {
    private $moneyEarn = 0;
    private $lossOfEarning = 0;

    public function addRevenue($amount) {
        $this->moneyEarn += $amount;
    }

    public function addLost($amount) {
        $this->lossOfEarning += $amount;
    }

    public function onTick($tick) {}

    public function getReport(): array {
        return [
            "moneyEarn" => $this->moneyEarn,
            "lossOfEarning" => $this->lossOfEarning
        ];
    }
}

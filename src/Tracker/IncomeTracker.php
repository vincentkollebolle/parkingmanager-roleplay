<?php
class IncomeTracker {
    private $moneyWon = 0;
    private $moneyLost = 0;

    public function addRevenue($amount) {
        $this->moneyWon += $amount;
    }

    public function addLost($amount) {
        $this->moneyLost += $amount;
    }

    public function onTick($tick) {}

    public function getReport(): array {
        return [
            "moneyWon" => $this->moneyWon,
            "moneyLost" => $this->moneyLost
        ];
    }
}

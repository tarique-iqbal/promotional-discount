<?php

declare(strict_types=1);

namespace PromotionalDiscount\Service;

final class PriceCalculator implements PriceCalculatorInterface
{
    private float $subtotal = 0.0;

    public function getSubtotal(): float
    {
        return $this->subtotal;
    }

    public function deductFromSubtotal(float $amount): void
    {
        $this->subtotal -= $amount;
    }

    public function addToSubtotal(float $amount): void
    {
        $this->subtotal += $amount;
    }
}

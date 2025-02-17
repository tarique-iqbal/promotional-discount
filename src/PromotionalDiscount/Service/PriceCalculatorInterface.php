<?php

declare(strict_types=1);

namespace PromotionalDiscount\Service;

interface PriceCalculatorInterface
{
    public function addToSubtotal(float $amount): void;

    public function getSubtotal(): float;

    public function deductFromSubtotal(float $amount): void;
}

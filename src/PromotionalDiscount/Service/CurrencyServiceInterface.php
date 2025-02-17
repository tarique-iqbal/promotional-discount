<?php

declare(strict_types=1);

namespace PromotionalDiscount\Service;

interface CurrencyServiceInterface
{
    public function getCurrencySymbol(): string;
}

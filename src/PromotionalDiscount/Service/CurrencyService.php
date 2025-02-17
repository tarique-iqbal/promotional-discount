<?php

declare(strict_types=1);

namespace PromotionalDiscount\Service;

final class CurrencyService implements CurrencyServiceInterface
{
    private const string CURRENCY_SYMBOL = '€';

    public function getCurrencySymbol(): string
    {
        return self::CURRENCY_SYMBOL;
    }
}

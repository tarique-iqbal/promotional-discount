<?php

declare(strict_types=1);

namespace PromotionalDiscount\PromotionalRules;

use PromotionalDiscount\Service\PriceCalculatorInterface;

final readonly class SpendOverThirtyPromotionalRule implements PromotionalRulesInterface
{
    private const int ORDER = 2;

    private const int SPEND_OVER_AMOUNT = 30;

    private const int PERCENTAGE_DISCOUNT = 10;

    public function __construct(private PriceCalculatorInterface $priceCalculator)
    {
    }

    public function apply(): void
    {
        $totalPrice = $this->priceCalculator->getSubtotal();

        if ($totalPrice > self::SPEND_OVER_AMOUNT) {
            $reduceAmount = ($totalPrice * self::PERCENTAGE_DISCOUNT) / 100;
            $this->priceCalculator->deductFromSubtotal($reduceAmount);
        }
    }

    public static function getOrder(): int
    {
        return self::ORDER;
    }
}

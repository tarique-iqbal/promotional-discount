<?php

declare(strict_types=1);

namespace Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use PromotionalDiscount\Service\PriceCalculator;
use PromotionalDiscount\Service\PriceCalculatorInterface;

class PriceCalculatorTest extends TestCase
{
    protected PriceCalculatorInterface $priceCalculator;

    protected function setUp(): void
    {
        $this->priceCalculator = new PriceCalculator();

        foreach ([5.50, 7.50, 10.50] as $amount) {
            $this->priceCalculator->addToSubtotal($amount);
        }
    }

    public function testGetProductDataSourceFile(): void
    {
        $subtotal = $this->priceCalculator->getSubtotal();

        $this->assertSame(23.50, $subtotal);
    }
}

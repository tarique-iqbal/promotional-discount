<?php

declare(strict_types=1);

namespace Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use PromotionalDiscount\Service\CurrencyService;
use PromotionalDiscount\Service\CurrencyServiceInterface;

class CurrencyServiceTest extends TestCase
{
    protected array $config;

    protected CurrencyServiceInterface $currencyService;

    protected function setUp(): void
    {
        $this->currencyService = new CurrencyService();
    }

    public function testGetProductDataSourceFile(): void
    {
        $currencySymbol = $this->currencyService->getCurrencySymbol();

        $this->assertSame('€', $currencySymbol);
    }
}

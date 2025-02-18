<?php

declare(strict_types=1);

namespace Tests\Integration\PromotionRules;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PromotionalDiscount\Container\ContainerFactory;
use PromotionalDiscount\PromotionalRules\SpendOverThirtyPromotionalRule;
use PromotionalDiscount\PromotionalRules\PromotionalRulesInterface;
use PromotionalDiscount\Service\BasketServiceInterface;
use PromotionalDiscount\Service\PriceCalculatorInterface;

class SpendOverThirtyPromotionalRuleTest extends TestCase
{
    protected PriceCalculatorInterface $priceCalculator;

    protected BasketServiceInterface $basketService;

    protected PromotionalRulesInterface $spendOverThirtyPromotionalRule;

    protected function setUp(): void
    {
        $config = include BASE_DIR . '/config/parameters_test.php';
        $container = new ContainerFactory($config)->create();

        $this->priceCalculator = $container['PriceCalculator'];
        $this->basketService = $container['BasketService'];
        $this->spendOverThirtyPromotionalRule = new SpendOverThirtyPromotionalRule($this->priceCalculator);
    }

    public static function itemsInBasketProvider(): array
    {
        return [
            [
                ['102', '102', '102'], 17.97
            ],
            [
                ['103', '103'], 45.00
            ],
            [
                ['101', '102', '103', '103'], 52.15
            ],
        ];
    }

    #[DataProvider('itemsInBasketProvider')]
    public function testApply(array $products, float $expectedSubtotal): void
    {
        $this->addProductToBasket($products);

        $this->spendOverThirtyPromotionalRule->apply();

        $subtotal = round($this->priceCalculator->getSubtotal(), 2);

        $this->assertSame($expectedSubtotal, $subtotal);
    }

    private function addProductToBasket(array $productCodes): void
    {
        foreach ($productCodes as $productCode) {
            $this->basketService->addToBasket($productCode);
        }
    }
}

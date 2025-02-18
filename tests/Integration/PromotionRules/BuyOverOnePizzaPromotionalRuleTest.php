<?php

declare(strict_types=1);

namespace Tests\Integration\PromotionRules;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PromotionalDiscount\Container\ContainerFactory;
use PromotionalDiscount\PromotionalRules\BuyOverOnePizzaPromotionalRule;
use PromotionalDiscount\PromotionalRules\PromotionalRulesInterface;
use PromotionalDiscount\Service\BasketServiceInterface;
use PromotionalDiscount\Service\PriceCalculatorInterface;

class BuyOverOnePizzaPromotionalRuleTest extends TestCase
{
    protected PriceCalculatorInterface $priceCalculator;

    protected BasketServiceInterface $basketService;

    protected PromotionalRulesInterface $buyOverOnePizzaPromotionalRule;

    protected function setUp(): void
    {
        $config = include BASE_DIR . '/config/parameters_test.php';
        $container = new ContainerFactory($config)->create();

        $this->priceCalculator = $container['PriceCalculator'];
        $this->basketService = $container['BasketService'];
        $this->buyOverOnePizzaPromotionalRule = new BuyOverOnePizzaPromotionalRule(
            $this->priceCalculator,
            $this->basketService,
            $container['ProductRepository']
        );
    }

    public static function itemsInBasketProvider(): array
    {
        return [
            [
                ['102'], 5.99
            ],
            [
                ['102', '102', '102'], 11.97
            ],
            [
                ['102', '102', '103'], 32.98
            ],
        ];
    }

    #[DataProvider('itemsInBasketProvider')]
    public function testApply(array $products, float $expectedSubtotal): void
    {
        $this->addProductToBasket($products);

        $this->buyOverOnePizzaPromotionalRule->apply();

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

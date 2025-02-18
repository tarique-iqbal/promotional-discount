<?php

declare(strict_types=1);

namespace Tests\Integration\Service;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PromotionalDiscount\Container\ContainerFactory;
use PromotionalDiscount\Service\BasketServiceInterface;

class BasketServiceTest extends TestCase
{
    protected BasketServiceInterface $basketService;

    protected function setUp(): void
    {
        $config = include BASE_DIR . '/config/parameters_test.php';
        $container = new ContainerFactory($config)->create();

        $this->basketService = $container['BasketService'];
    }

    public static function itemsInBasketProvider(): array
    {
        return [
            [
                ['102'], '102', 1
            ],
            [
                ['102', '102', '102'], '102', 3
            ],
            [
                ['102', '102', '103', '103'], '102', 2
            ],
        ];
    }

    #[DataProvider('itemsInBasketProvider')]
    public function testCountProductInBasket(array $products, string $productCode, int $expectedCount): void
    {
        $this->addProductToBasket($products);

        $count = $this->basketService->countProductInBasket($productCode);

        $this->assertSame($expectedCount, $count);
    }

    private function addProductToBasket(array $productCodes): void
    {
        foreach ($productCodes as $productCode) {
            $this->basketService->addToBasket($productCode);
        }
    }
}

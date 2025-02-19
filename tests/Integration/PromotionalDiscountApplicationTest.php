<?php

declare(strict_types=1);

namespace Tests\Integration;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PromotionalDiscount\Container\ContainerFactory;
use PromotionalDiscount\PromotionalDiscountApplication;

class PromotionalDiscountApplicationTest extends TestCase
{
    protected PromotionalDiscountApplication $promotionalDiscountApplication;

    protected function setUp(): void
    {
        $config = include BASE_DIR . '/config/parameters_test.php';
        $container = new ContainerFactory($config)->create();

        $this->promotionalDiscountApplication = $container['PromotionalDiscountApplication'];
    }

    public static function itemsInBasketProvider(): array
    {
        return [
            [
                ['101', '102', '103'], '€29.65'
            ],
            [
                ['102', '101', '102'], '€9.93'
            ],
            [
                ['102', '101', '102', '103'], '€31.44'
            ],
            [
                ['101', '102', '102', '103', '103'], '€53.94'
            ],
        ];
    }

    #[DataProvider('itemsInBasketProvider')]
    public function testRun(array $itemsInBasket, string $expectedPrice): void
    {
        $this->expectOutputString($expectedPrice . PHP_EOL);

        $this->promotionalDiscountApplication->run($itemsInBasket);
    }
}

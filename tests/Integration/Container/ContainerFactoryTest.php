<?php

declare(strict_types=1);

namespace Tests\Integration\Container;

use PHPUnit\Framework\TestCase;
use Pimple\Container;
use PromotionalDiscount\Container\ContainerFactory;
use PromotionalDiscount\Factory\PromotionalRulesFactory;
use PromotionalDiscount\Handler\ExceptionHandler;
use PromotionalDiscount\PromotionalDiscountApplication;
use PromotionalDiscount\Repository\ProductRepository;
use PromotionalDiscount\Service\BasketService;
use PromotionalDiscount\Service\ConfigService;
use PromotionalDiscount\Service\CurrencyService;
use PromotionalDiscount\Service\PromotionEngineService;

class ContainerFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $config = include BASE_DIR . '/config/parameters_test.php';

        $container = new ContainerFactory($config)->create();

        $this->assertInstanceOf(Container::class, $container);
        $this->assertInstanceOf(ConfigService::class, $container['ConfigService']);
        $this->assertInstanceOf(ProductRepository::class, $container['ProductRepository']);
        $this->assertInstanceOf(BasketService::class, $container['BasketService']);
        $this->assertInstanceOf(PromotionalRulesFactory::class, $container['PromotionalRulesFactory']);
        $this->assertInstanceOf(CurrencyService::class, $container['CurrencyService']);
        $this->assertInstanceOf(PromotionEngineService::class, $container['PromotionEngineService']);
        $this->assertInstanceOf(PromotionalDiscountApplication::class, $container['PromotionalDiscountApplication']);
        $this->assertInstanceOf(ExceptionHandler::class, $container['ExceptionHandler']);
    }
}

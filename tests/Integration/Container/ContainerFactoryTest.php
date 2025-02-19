<?php

declare(strict_types=1);

namespace Tests\Integration\Container;

use PHPUnit\Framework\TestCase;
use Pimple\Container;
use PromotionalDiscount\Container\ContainerFactory;
use PromotionalDiscount\Factory\PromotionalRulesFactory;
use PromotionalDiscount\Repository\ProductRepository;
use PromotionalDiscount\Service\BasketService;
use PromotionalDiscount\Service\ConfigService;

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
    }
}

<?php

declare(strict_types=1);

namespace PromotionalDiscount\Container;

use Pimple\Container;
use PromotionalDiscount\Repository\ProductRepository;
use PromotionalDiscount\Service\ConfigService;
use PromotionalDiscount\Service\PriceCalculator;

readonly class ContainerFactory
{
    public function __construct(private array $config)
    {
    }

    public function create(): Container
    {
        $container = new Container();

        $container['ConfigService'] = function () {
            return new ConfigService($this->config);
        };

        $container['ProductRepository'] = function (Container $c) {
            return new ProductRepository(
                $c['ConfigService']->getProductDataSourceFile()
            );
        };

        $container['PriceCalculator'] = function () {
            return new PriceCalculator();
        };

        return $container;
    }
}

<?php

declare(strict_types=1);

namespace PromotionalDiscount\Container;

use Pimple\Container;
use PromotionalDiscount\Factory\PromotionalRulesFactory;
use PromotionalDiscount\Repository\ProductRepository;
use PromotionalDiscount\Service\BasketService;
use PromotionalDiscount\Service\ConfigService;
use PromotionalDiscount\Service\PriceCalculator;

final readonly class ContainerFactory
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

        $container['BasketService'] = function (Container $c) {
            return new BasketService(
                $c['ProductRepository'],
                $c['PriceCalculator'],
            );
        };

        $container['PromotionalRulesFactory'] = function (Container $c) {
            return new PromotionalRulesFactory(
                $c['PriceCalculator'],
                $c['BasketService'],
                $c['ProductRepository']
            );
        };

        return $container;
    }
}

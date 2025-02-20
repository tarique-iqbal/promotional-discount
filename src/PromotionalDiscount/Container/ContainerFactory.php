<?php

declare(strict_types=1);

namespace PromotionalDiscount\Container;

use Pimple\Container;
use PromotionalDiscount\Factory\PromotionalRulesFactory;
use PromotionalDiscount\Handler\ExceptionHandler;
use PromotionalDiscount\PromotionalDiscountApplication;
use PromotionalDiscount\Repository\ProductRepository;
use PromotionalDiscount\Service\BasketService;
use PromotionalDiscount\Service\ConfigService;
use PromotionalDiscount\Service\CurrencyService;
use PromotionalDiscount\Service\PriceCalculator;
use PromotionalDiscount\Service\PromotionEngineService;

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

        $container['CurrencyService'] = function () {
            return new CurrencyService();
        };

        $container['PromotionEngineService'] = function () {
            return new PromotionEngineService();
        };

        $container['PromotionalDiscountApplication'] = function (Container $c) {
            return new PromotionalDiscountApplication(
                $c['BasketService'],
                $c['CurrencyService'],
                $c['PriceCalculator'],
                $c['PromotionalRulesFactory'],
                $c['PromotionEngineService']
            );
        };

        $container['ExceptionHandler'] = function (Container $c) {
            return new ExceptionHandler(
                $c['ConfigService'],
            );
        };

        return $container;
    }
}

<?php

declare(strict_types=1);

namespace PromotionalDiscount\PromotionalRules;

use PromotionalDiscount\Repository\ProductRepositoryInterface;
use PromotionalDiscount\Service\BasketServiceInterface;
use PromotionalDiscount\Service\PriceCalculator;

final readonly class BuyOverOnePizzaPromotionalRule implements PromotionalRulesInterface
{
    private const int ORDER = 1;

    public const string PRODUCT_CODE_PIZZA = '102';

    public function __construct(
        private PriceCalculator $priceCalculator,
        private BasketServiceInterface $basketService,
        private ProductRepositoryInterface $productRepository,
    ) {
    }

    public function apply(): void
    {
        $pizzaCount = $this->basketService->countProductInBasket(self::PRODUCT_CODE_PIZZA);

        if ($pizzaCount > 1) {
            $productPizza = $this->productRepository->findByCode(self::PRODUCT_CODE_PIZZA);
            $reduceAmount = ($productPizza->getPrice() - $productPizza->getReducePrice()) * $pizzaCount;
            $this->priceCalculator->deductFromSubtotal($reduceAmount);
        }
    }

    public static function getOrder(): int
    {
        return self::ORDER;
    }
}

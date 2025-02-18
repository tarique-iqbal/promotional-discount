<?php

declare(strict_types=1);

namespace PromotionalDiscount\Service;

use PromotionalDiscount\Repository\ProductRepositoryInterface;

class BasketService implements BasketServiceInterface
{
    private array $productCodes = [];

    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly PriceCalculatorInterface $priceCalculator,
    ) {
    }

    public function addToBasket(string $productCode): void
    {
        $product = $this->productRepository->findByCode($productCode);
        $this->productCodes[] = $product->getCode();

        $this->priceCalculator->addToSubtotal($product->getPrice());
    }

    public function countProductInBasket(string $productCode): int
    {
        if (in_array($productCode, $this->productCodes, true)) {
            return array_count_values($this->productCodes)[$productCode];
        }

        return 0;
    }
}

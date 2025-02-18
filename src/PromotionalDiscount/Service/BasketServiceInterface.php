<?php

declare(strict_types=1);

namespace PromotionalDiscount\Service;

interface BasketServiceInterface
{
    public function addToBasket(string $productCode): void;

    public function countProductInBasket(string $productCode): int;
}

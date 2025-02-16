<?php

declare(strict_types=1);

namespace PromotionalDiscount\Repository;

use PromotionalDiscount\Entity\Product;

interface ProductRepositoryInterface
{
    public function findByCode(string $code): Product;
}

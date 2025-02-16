<?php

declare(strict_types=1);

namespace PromotionalDiscount\Entity;

readonly class Product
{
    public function __construct(
        private string $code,
        private string $name,
        private float $price,
        private ?float $reducePrice,
    ) {
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getReducePrice(): ?float
    {
        return $this->reducePrice;
    }
}

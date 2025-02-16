<?php

declare(strict_types=1);

namespace PromotionalDiscount\Repository;

use PromotionalDiscount\Entity\Product;

class ProductRepository implements ProductRepositoryInterface
{
    private array $products;

    public function __construct(string $productDataSourceFile)
    {
        $jsonString = file_get_contents($productDataSourceFile, true);
        $dataSource = json_decode($jsonString, true);

        foreach ($dataSource['product'] as $item) {
            $product = new Product(
                $item['code'],
                $item['name'],
                $item['price'],
                $item['reduce_price'],
            );

            $this->products[$item['code']] = $product;
        }
    }

    public function findByCode(string $code): Product
    {
        return $this->products[$code];
    }
}

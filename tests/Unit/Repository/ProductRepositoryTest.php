<?php

declare(strict_types=1);

namespace Tests\Unit\Repository;

use bovigo\vfs\vfsStream;
use bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;
use PromotionalDiscount\Entity\Product;
use PromotionalDiscount\Repository\ProductRepository;

class ProductRepositoryTest extends TestCase
{
    private vfsStreamDirectory $root;

    protected function setUp(): void
    {
        $structure = [
            'data' => [
                'product.json' => '{
                    "product": {
                        "1": {
                            "code": "101",
                            "name": "Curry Sauce",
                            "price": 1.95,
                            "reduce_price": null
                        }
                    }
                }'
            ]
        ];

        $this->root = vfsStream::setup(sys_get_temp_dir(), null, $structure);
    }

    public function testFindByCode()
    {
        $productRepository = new ProductRepository(
            $this->root->url() . '/data/product.json'
        );

        $product = $productRepository->findByCode('101');

        $this->assertInstanceOf(Product::class, $product);
    }
}

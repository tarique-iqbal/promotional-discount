<?php

declare(strict_types=1);

namespace Tests\Integration\Factory;

use PHPUnit\Framework\TestCase;
use PromotionalDiscount\Container\ContainerFactory;
use PromotionalDiscount\Factory\PromotionalRulesFactory;
use PromotionalDiscount\PromotionalRules\PromotionalRulesInterface;

class PromotionalRulesFactoryTest extends TestCase
{
    protected PromotionalRulesFactory $promotionalRulesFactory;

    protected function setUp(): void
    {
        $config = include BASE_DIR . '/config/parameters_test.php';
        $container = new ContainerFactory($config)->create();

        $this->promotionalRulesFactory = $container['PromotionalRulesFactory'];
    }

    public function testCreate(): void
    {
        $objects = $this->promotionalRulesFactory->create();
        $this->assertContainsOnlyInstancesOf(PromotionalRulesInterface::class, $objects);
    }
}

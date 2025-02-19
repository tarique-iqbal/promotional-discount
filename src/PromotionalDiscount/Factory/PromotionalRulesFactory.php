<?php

declare(strict_types=1);

namespace PromotionalDiscount\Factory;

use DirectoryIterator;
use PromotionalDiscount\PromotionalRules\PromotionalRulesInterface;
use PromotionalDiscount\Repository\ProductRepositoryInterface;
use PromotionalDiscount\Service\BasketServiceInterface;
use PromotionalDiscount\Service\PriceCalculatorInterface;
use ReflectionClass;
use ReflectionException;

final readonly class PromotionalRulesFactory
{
    public function __construct(
        private PriceCalculatorInterface $priceCalculator,
        private BasketServiceInterface $basketService,
        private ProductRepositoryInterface $productRepository,
    ) {
    }

    /**
     * @throws ReflectionException
     */
    public function create(): array
    {
        $promotionRulesClasses = $this->getPromotionRulesClasses();

        $promotionRules = [];
        foreach ($promotionRulesClasses as $class) {
            $object = new $class($this->priceCalculator, $this->basketService, $this->productRepository);
            if ($object instanceof PromotionalRulesInterface) {
                $promotionRules[] = $object;
            }
        }

        return $this->sortPromotionRules($promotionRules);
    }

    /**
     * @throws ReflectionException
     */
    private function getPromotionRulesClasses(): array
    {
        $promotionRulesClasses = [];
        foreach (new DirectoryIterator(dirname(__DIR__) . '/PromotionalRules/') as $fileInfo) {
            if ($fileInfo->isFile() && $fileInfo->getExtension() === 'php') {
                $className = 'PromotionalDiscount\\PromotionalRules\\' . $fileInfo->getBasename('.php');
                $reflection = new ReflectionClass($className);
                if ($reflection->isInstantiable()) {
                    $promotionRulesClasses[] = $className;
                }
            }
        }

        return $promotionRulesClasses;
    }

    private function sortPromotionRules(array $promotionRules): array
    {
        usort(
            $promotionRules,
            static function (PromotionalRulesInterface $a, PromotionalRulesInterface $b) {
                return $a::getOrder() - $b::getOrder();
            }
        );

        return $promotionRules;
    }
}

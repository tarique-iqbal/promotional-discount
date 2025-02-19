<?php

declare(strict_types=1);

namespace PromotionalDiscount;

use PromotionalDiscount\Factory\PromotionalRulesFactory;
use PromotionalDiscount\Service\BasketServiceInterface;
use PromotionalDiscount\Service\CurrencyServiceInterface;
use PromotionalDiscount\Service\PriceCalculatorInterface;
use PromotionalDiscount\Service\PromotionEngineServiceInterface;
use ReflectionException;

final readonly class PromotionalDiscountApplication
{
    public function __construct(
        private BasketServiceInterface $basketService,
        private CurrencyServiceInterface $currencyService,
        private PriceCalculatorInterface $priceCalculator,
        private PromotionalRulesFactory $promotionRulesFactory,
        private PromotionEngineServiceInterface $promotionEngineService
    ) {
    }

    /**
     * @throws ReflectionException
     */
    public function run(array $itemsInBasket): void
    {
        // Add a few products to the basket
        foreach ($itemsInBasket as $productCode) {
            $this->basketService->addToBasket($productCode);
        }

        $promotionRules = $this->promotionRulesFactory->create();
        $this->promotionEngineService->setRules($promotionRules);
        $this->promotionEngineService->run();

        // Display the amount after promotions
        echo $this->currencyService->getCurrencySymbol()
            . round($this->priceCalculator->getSubtotal(), 2)
            . PHP_EOL;
    }
}

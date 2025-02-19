<?php

declare(strict_types=1);

namespace PromotionalDiscount\Service;

use PromotionalDiscount\PromotionalRules\PromotionalRulesInterface;

final class PromotionEngineService implements PromotionEngineServiceInterface
{
    /**
     * @var PromotionalRulesInterface[]
     */
    private array $promotionRules;

    /**
     * @param PromotionalRulesInterface[] $promotionRules
     */
    public function setRules(array $promotionRules): void
    {
        $this->promotionRules = $promotionRules;
    }

    public function run(): void
    {
        foreach ($this->promotionRules as $promotionRule) {
            $promotionRule->apply();
        }
    }
}

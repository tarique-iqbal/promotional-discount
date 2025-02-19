<?php

declare(strict_types=1);

namespace PromotionalDiscount\Service;

use PromotionalDiscount\PromotionalRules\PromotionalRulesInterface;

interface PromotionEngineServiceInterface
{
    /**
     * @param PromotionalRulesInterface[] $promotionRules
     */
    public function setRules(array $promotionRules): void;

    public function run(): void;
}

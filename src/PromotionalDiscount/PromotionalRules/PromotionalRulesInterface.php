<?php

declare(strict_types=1);

namespace PromotionalDiscount\PromotionalRules;

interface PromotionalRulesInterface
{
    public function apply(): void;

    public static function getOrder(): int;
}

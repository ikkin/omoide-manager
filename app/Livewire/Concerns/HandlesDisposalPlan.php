<?php

namespace App\Livewire\Concerns;

use App\Constants\ItemConstants;

/**
 * @property int $disposal_plan
 * @property ?int $discard_cost
 * @property ?int $sale_price
 * @property ?string $transfer_target
 * @property ?string $storage_deadline
 */

trait HandlesDisposalPlan
{
    public function updatedDisposalPlan(): void
    {
        if ($this->disposal_plan != ItemConstants::DISPOSAL_PLAN_DISCARD) {
            $this->discard_cost = null;
        }
        if ($this->disposal_plan != ItemConstants::DISPOSAL_PLAN_SALE) {
            $this->sale_price = null;
        }
        if ($this->disposal_plan != ItemConstants::DISPOSAL_PLAN_TRANSFER) {
            $this->transfer_target = null;
        }
        if ($this->disposal_plan != ItemConstants::DISPOSAL_PLAN_STORAGE) {
            $this->storage_deadline = null;
        }
    }
}
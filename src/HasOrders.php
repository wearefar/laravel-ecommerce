<?php

namespace WeAreFar\Ecommerce;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use WeAreFar\Ecommerce\Models\Order;

trait HasOrders
{
    public $quantity;

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_items', 'item_id', 'order_id')
                    ->withPivot('quantity', 'unit_price', 'total');
    }

    public function getNameAttribute(): ?string
    {
        return $this->name;
    }

    public function isOutOfStock(): bool
    {
        return $this->stock === 0;
    }

    public function hasLowStock(): bool
    {
        return $this->stock > 0 && $this->stock <= $this->getLowStockThreshold();
    }

    public function hasUnlimitedStock(): bool
    {
        return $this->stock === -1;
    }

    public function hasStock(int $quantity): bool
    {
        return $this->stock >= $quantity || $this->hasUnlimitedStock();
    }

    protected function getLowStockThreshold(): int
    {
        return config('ecommerce.low_stock_threshold', 10);
    }
}

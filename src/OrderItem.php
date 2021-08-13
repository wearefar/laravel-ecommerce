<?php

namespace WeAreFar\Ecommerce;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface OrderItem
{
    public function orders(): BelongsToMany;

    public function getNameAttribute(): ?string;

    public function getThumbnailAttribute(): ?string;

    public function isOutOfStock(): bool;

    public function hasStock(int $quantity): bool;
}

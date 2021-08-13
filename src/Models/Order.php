<?php

namespace WeAreFar\Ecommerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use WeAreFar\Ecommerce\Exceptions\NotEnoughStockException;
use WeAreFar\Ecommerce\Exceptions\OutOfStockException;
use WeAreFar\Ecommerce\OrderItem;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function booting()
    {
        self::creating(function ($order) {
            $order->code = strtoupper(Str::random(6));
        });
    }

    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function customer()
    {
        return $this->morphTo();
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function items()
    {
        // TODO: Polymorphic relationship would be better here
        // Probably change to Morph To Many
        return $this->belongsToMany(config('ecommerce.order_item_model'), 'order_items', 'order_id', 'item_id')->withPivot('quantity', 'unit_price', 'total');
    }

    public function addItem(OrderItem $item, int $quantity = 1)
    {
        if ($this->hasItem($item)) {
            $quantity = $this->getItem($item)->pivot->quantity + $quantity;
        }

        $this->updateItem($item, $quantity);
    }

    public function updateItem(OrderItem $item, int $quantity)
    {
        if ($item->isOutOfStock()) {
            throw new OutOfStockException($item);
        }

        if (! $item->hasStock($quantity)) {
            throw new NotEnoughStockException($item);
        }

        if ($quantity <= 0) {
            $this->remove($product);
            return;
        }

        // Is there an alternative to this?
        $this->items()->sync([$item->id => [
            'quantity' => $quantity,
            'unit_price' => $item->price,
            'total' => $quantity * $item->price,
        ]], false);

        $this->updateTotals();
    }

    public function updateTotals()
    {
        // Don't like this here...
        $this->refresh();

        $this->items_total = $this->items->sum('pivot.total');
        $this->adjustments_total = 0; // TODO
        $this->total = $this->items_total + $this->adjustments_total;

        $this->save();
    }

    public function removeItem(OrderItem $item)
    {
        $this->items()->detach($item);

        $this->updateTotals();
    }

    public function hasItem(OrderItem $item)
    {
        return $this->items->contains($item);
    }

    public function getItem(OrderItem $item)
    {
        return $this->items->find($item);
    }
}

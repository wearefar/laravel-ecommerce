<?php

namespace WeAreFar\Ecommerce\Exceptions;

use Exception;

class NotEnoughStockException extends Exception
{
    public $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json([
            'message' => "Not enough stock for product \"{$this->product->name}\". Only {$this->product->stock} available.",
            'error' => [
                'code' => 'not_enough_stock',
                'productId' => $this->product->id,
                'stock' => $this->product->stock
            ],
        ], 406);
    }
}

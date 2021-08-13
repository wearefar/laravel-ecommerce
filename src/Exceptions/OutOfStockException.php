<?php

namespace WeAreFar\Ecommerce\Exceptions;

use Exception;

class OutOfStockException extends Exception
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
            'message' => "Product \"{$this->product->name}\" is out of stock",
            'error' => [
                'code' => 'out_of_stock',
                'productId' => $this->product->id,
                'stock' => $this->product->stock,
            ],
        ], 406);
    }
}

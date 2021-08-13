<?php

namespace WeAreFar\Ecommerce\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class OrderStatus extends BooleanFilter
{
    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        $whereIn = array_keys(array_filter($value));

        return $query->when($whereIn, function ($query) use ($whereIn) {
            return $query->whereIn('status', $whereIn);
        }, function ($query) {
            return $query->where('status', '!=', 'cart');
        });
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            'Cart' => 'cart',
            'Draft' => 'draft',
            'Pending' => 'pending', // maybe remove?
            'Succeeded' => 'succeeded',
            'Shipped' => 'shipped',
            'Refunded' => 'refunded',
            'Failed' => 'failed',
        ];
    }

    // public function default()
    // {
    //     return [
    //         'cart' => false,
    //         'draft' => true,
    //         'pending' => true,
    //         'succeeded' => true,
    //         'shipped' => true,
    //         'refunded' => true,
    //         'failed' => true,
    //     ];
    // }
}

<?php

namespace WeAreFar\Ecommerce\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use WeAreFar\Ecommerce\Nova\Resource;

class Payment extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \WeAreFar\Ecommerce\Models\Payment::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            BelongsTo::make('Order')->displayUsing(function ($order) {
                return $order->code;
            }),
            Text::make('Stripe ID'),
            Currency::make(__('Amount'))
                ->asMinorUnits()
                ->exceptOnForms(),
            Currency::make(__('Amount'))
                ->resolveUsing(function ($value) {
                    return number_format($value / 100, 2);
                })
                ->fillUsing(function (NovaRequest $request, $model, $attribute, $requestAttribute) {
                    $model->{$attribute} = $request[$requestAttribute] * 100;
                })
                ->onlyOnForms(),
            Badge::make('Status')
            ->displayUsing(function ($value) {
                return str_replace('_', ' ', $value);
            })
            ->map([
                'requires confirmation' => 'info',
                'requires action' => 'warning',
                'processing' => 'warning',
                'requires capture' => 'info',
                'canceled' => 'info',
                'succeeded' => 'success',
            ])
            ->addTypes([
                'requires payment method' => 'bg-50',
            ]),
            Text::make('Card brand')->hideFromIndex(),
            Text::make('Card last four')->hideFromIndex(),
            Text::make('Last error message', 'stripe_error_message')
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}

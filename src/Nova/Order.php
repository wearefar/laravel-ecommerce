<?php

namespace WeAreFar\Ecommerce\Nova;

// use App\Nova\Actions\MarkAsShipped;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\ActionRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Symfony\Component\Intl\Countries;
use WeAreFar\Ecommerce\Nova\Actions\MarkAsShipped;
use WeAreFar\Ecommerce\Nova\Resource;

class Order extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \WeAreFar\Ecommerce\Models\Order::class;

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
        'code',
    ];

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Orders');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Order');
    }

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
            Text::make('Code'),
            BelongsTo::make('Customer'),
            Currency::make(__('Total'))
                ->asMinorUnits()
                ->exceptOnForms(),
            Currency::make(__('Total'))
                ->resolveUsing(function ($value) {
                    return number_format($value / 100, 2);
                })
                ->fillUsing(function (NovaRequest $request, $model, $attribute, $requestAttribute) {
                    $model->{$attribute} = $request[$requestAttribute] * 100;
                })
                ->onlyOnForms(),
            Badge::make('Status')->map([
                'failed' => 'danger',
                'succeeded' => 'info',
                'pending' => 'warning',
                'shipped' => 'success',
            ])->addTypes([
                'cart' => 'bg-50',
                'draft' => 'bg-50',
                'refunded' => 'bg-50',
            ]),
            Select::make('status')->options([
                'cart' => 'Cart',
                'draft' => 'Draft',
                'pending' => 'Pending',
                'succeeded' => 'Succeeded',
                'shipped' => 'Shipped',
                'refunded' => 'Refunded',
                'failed' => 'Failed',
            ])->onlyOnForms(),
            DateTime::make('Date', 'created_at'),
            Textarea::make('Shipping Address', function () {
                if (! $this->shippingAddress || ! $this->customer) {
                    return null;
                }

                return collect([
                    $this->customer->name,
                    $this->shippingAddress->address_line_1,
                    $this->shippingAddress->address_line_2,
                    "{$this->shippingAddress->zip} {$this->shippingAddress->city}, {$this->shippingAddress->state}",
                    Countries::getName($this->shippingAddress->country, app()->getLocale()),
                    $this->shippingAddress->phone,
                ])->filter()->join("\n");
            })->alwaysShow(),
            Textarea::make('Comments')->alwaysShow(),
            Text::make('Tracking number')->hideFromIndex(),
            BelongsToMany::make('Items', 'items', config('ecommerce.order_item_nova_resource'))
                ->fields(function () {
                    return [
                        Number::make('Quantity'),
                        Currency::make('Price', 'unit_price')->asMinorUnits(),
                        Currency::make('Total', 'total')->asMinorUnits(),
                    ];
                }),
            // BelongsTo::make('Shipping Address', 'shippingAddress', Address::class)
            //     ->hideFromIndex(),
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
        return [
            new Filters\OrderStatus,
        ];
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
        return [
            (new MarkAsShipped)->canSee(function ($request) {
                if ($request instanceof ActionRequest) {
                    return true;
                }

                return $this->resource->isReadyForShipping();
            })->showOnTableRow(),
        ];
    }
}

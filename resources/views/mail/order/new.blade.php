@component('mail::message')
# @lang('Hello!')

@lang('You received a new order from :name for :total. Please remember to change the status of the order sent when you have delivered it to the courier service.',
    [
        'name' => $order->customer->name,
        'total' => money($order->total)
    ]
)

@component('mail::panel')
@lang('Code'): **{{ $order->code }}**<br>
@lang('Total'): **{{ money($order->total) }}**<br>
@lang('Status'): **{{ $order->status }}**<br>
@lang('Date'): **{{ $order->created_at->format(('d-m-Y H:i')) }}**<br>
@endcomponent

@include ('ecommerce::mail.order._table')

@component('mail::panel')
**@lang('Shipping Address')**<br>
@include('ecommerce::mail.order._address')
@endcomponent

@component('mail::button', ['url' => url(config('nova.path') . "/resources/orders/{$order->id}")])
@lang('Manage order')
@endcomponent

@lang('Regards'),<br>
{{ config('app.name') }}
@endcomponent

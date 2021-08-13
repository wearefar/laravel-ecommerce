<?php

namespace WeAreFar\Ecommerce;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;
use Livewire\Livewire;
use WeAreFar\Ecommerce\Http\Livewire\CheckoutReview;
use WeAreFar\Ecommerce\Http\Livewire\CheckoutShipping;
use WeAreFar\Ecommerce\Http\Livewire\ShoppingCart;
use WeAreFar\Ecommerce\Nova\Address;
use WeAreFar\Ecommerce\Nova\Customer;
use WeAreFar\Ecommerce\Nova\Order;
use WeAreFar\Ecommerce\Nova\Payment;
use WeAreFar\Ecommerce\Providers\EventServiceProvider;
use WeAreFar\Ecommerce\View\Components\AppLayout;
use WeAreFar\Ecommerce\View\Components\CountrySelect;

class EcommerceServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/ecommerce.php', 'ecommerce');

        $this->app->register(EventServiceProvider::class);
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'ecommerce');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'ecommerce');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../resources/lang');

        $this->registerRoutes();
        $this->registerBladeComponents();
        $this->registerLivewireComponents();
        $this->registerPublishing();

        $this->registerNovaResources();

        Relation::morphMap([
            'customer' => 'WeAreFar\Ecommerce\Models\Customer',
        ]);
    }

    private function registerBladeComponents()
    {
        Blade::componentNamespace('WeAreFar\\Ecommerce\\View\\Components', 'ecommerce');
        Blade::component('ecommerce::components.add-to-cart', 'add-to-cart');
        Blade::component('ecommerce::components.cart-button', 'cart-button');
    }

    private function registerLivewireComponents()
    {
        Livewire::component('shopping-cart', ShoppingCart::class);
        Livewire::component('checkout-shipping', CheckoutShipping::class);
        Livewire::component('checkout-review', CheckoutReview::class);
    }

    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/ecommerce.php' => config_path('ecommerce.php'),
            ], 'config');

            if (! class_exists('CreateOrdersTable')) {
                $this->publishes([
                    __DIR__.'/../database/migrations/create_orders_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_orders_table.php'),
                    __DIR__.'/../database/migrations/create_addresses_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_addresses_table.php'),
                    __DIR__.'/../database/migrations/create_customers_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_customers_table.php'),
                ], 'migrations');
            }

            $this->publishes([
                __DIR__.'/../resources/views' => $this->app->resourcePath('views/vendor/ecommerce'),
            ], 'views');

            $this->publishes([
                __DIR__ .'/../resources/lang' => $this->app->langPath('vendor/ecommerce'),
            ], 'lang');
        }
    }

    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    protected function routeConfiguration()
    {
        return [
            'prefix' => config('ecommerce.prefix'),
            'middleware' => config('ecommerce.middleware'),
        ];
    }

    private function registerNovaResources()
    {
        // Skip if Laravel Nova isn't installed.
        if (! class_exists(Nova::class)) {
            return;
        }

        Nova::resources([
            Order::class,
            Customer::class,
            Address::class,
            Payment::class,
        ]);
    }
}

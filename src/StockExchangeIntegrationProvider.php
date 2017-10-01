<?php

namespace Warchiefs\StockExchangeIntegration;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Warchiefs\StockExchangeIntegration\Containers\{
    Poloniex,
    StockExchange
};

class StockExchangeIntegrationProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
	    $this->publishes([
		    __DIR__.'/Config/exchange.php' => config_path('exchange.php'),
	    ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $exchange = ucfirst(Config::get('exchange.selected'));
        $exchange_path = __NAMESPACE__ . '\\Containers\\' . $exchange;

        if (!class_exists($exchange_path)) {
            $exchange_path = Poloniex::class;
        }

	    $this->app->bind(
            StockExchange::class,
		    $exchange_path
	    );

	    $this->app->bind(
		    'StockExchange',
		    $exchange_path
	    );
    }
}

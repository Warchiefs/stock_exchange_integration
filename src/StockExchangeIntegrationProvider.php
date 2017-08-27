<?php

namespace Warchiefs\StockExchangeIntegration;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

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
	    include __DIR__.'/routes.php';

    	switch (Config::get('exchange.selected')) {
		    case 'poloniex':
		    	$exchange_path = 'Warchiefs\StockExchangeIntegration\Containers\Poloniex';
		    	break;
		    case 'kraken':
			    $exchange_path = 'Warchiefs\StockExchangeIntegration\Containers\Kraken';
		    	break;
		    default:
			    $exchange_path = 'Warchiefs\StockExchangeIntegration\Containers\Poloniex';
		    	break;
	    }

	    $this->app->bind(
		    'Warchiefs\StockExchangeIntegration\Contracts\StockExchange',
		    $exchange_path
	    );

	    $this->app->bind(
		    'Warchiefs\StockExchangeIntegration\Facades\StockExchange',
		    $exchange_path
	    );
    }
}

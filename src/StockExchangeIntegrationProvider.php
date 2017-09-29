<?php

namespace Warchiefs\StockExchangeIntegration;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Warchiefs\StockExchangeIntegration\Containers\{
    Poloniex,
    Kraken,
    Bithumb,
    Bitfinex,
    Bitflyer,
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
    	switch (Config::get('exchange.selected')) {
		    case 'poloniex':
		    	$exchange_path = Poloniex::class;
		    	break;
		    case 'kraken':
			    $exchange_path = Kraken::class;
		    	break;
            case 'bithumb':
                $exchange_path = Bithumb::class;
                break;
            case 'bitfinex':
                $exchange_path = Bitfinex::class;
                break;
            case 'bitflyer':
                $exchange_path = Bitflyer::class;
                break;
		    default:
			    $exchange_path = Poloniex::class;
		    	break;
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

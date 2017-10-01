<?php

use Warchiefs\StockExchangeIntegration\Contracts\StockExchange as Exchange;
use Illuminate\Support\Facades\Config;

Route::prefix('exchange/api')->group(function () {
	Route::any('/pairs', function(Exchange $exchange){
		return $exchange->getAvailableQuotation();
	});
	Route::any('/ticker', function(Exchange $exchange){
		return $exchange->getInfoAboutPair(\Illuminate\Support\Facades\Request::get('first_currency'), \Illuminate\Support\Facades\Request::get('second_currency'));
	});
	Route::any('/chart', function(Exchange $exchange){
		switch (Config::get('exchange.selected')) {
			case 'kraken':
				return $exchange->getJsonByPair(\Illuminate\Support\Facades\Request::get('first_currency'), \Illuminate\Support\Facades\Request::get('second_currency'), \Illuminate\Support\Facades\Request::get('interval'), \Illuminate\Support\Facades\Request::get('since'));
			case 'poloniex':
				return $exchange->getJsonByPair(\Illuminate\Support\Facades\Request::get('first_currency'), \Illuminate\Support\Facades\Request::get('second_currency'), \Illuminate\Support\Facades\Request::get('start'), \Illuminate\Support\Facades\Request::get('end'), \Illuminate\Support\Facades\Request::get('period'));
			default:
				return $exchange->getJsonByPair(\Illuminate\Support\Facades\Request::get('first_currency'), \Illuminate\Support\Facades\Request::get('second_currency'), \Illuminate\Support\Facades\Request::get('interval'));
		}
	});
	Route::any('/trades', function(Exchange $exchange){
		switch (Config::get('exchange.selected')) {
			case 'kraken':
				return $exchange->getTradeHistory(\Illuminate\Support\Facades\Request::get('first_currency'), \Illuminate\Support\Facades\Request::get('second_currency'), \Illuminate\Support\Facades\Request::get('since'));
			case 'poloniex':
				return $exchange->getTradeHistory(\Illuminate\Support\Facades\Request::get('first_currency'), \Illuminate\Support\Facades\Request::get('second_currency'), \Illuminate\Support\Facades\Request::get('start'), \Illuminate\Support\Facades\Request::get('end'));
			default:
				return $exchange->getTradeHistory(\Illuminate\Support\Facades\Request::get('first_currency'), \Illuminate\Support\Facades\Request::get('second_currency'), \Illuminate\Support\Facades\Request::get('interval'));
		}
	});
});
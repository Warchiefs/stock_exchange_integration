<?php

namespace Warchiefs\StockExchangeIntegration\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Warchiefs\StockExchangeIntegration\Contracts\StockExchange as Exchange;

class StockExchangeApiController extends Controller
{
	protected $exchange;

	public function __construct(Exchange $exchange)
	{
		$this->exchange = $exchange;
	}

	public function getAvailableQuotation()
	{
		return $this->exchange->getAvailableQuotation();
	}

	public function getInfoAboutPair(Request $request)
	{
		return $this->exchange->getInfoAboutPair($request->get('pair'));
	}

	public function getJsonByPair(Request $request)
	{
		switch (config('exchange.selected')) {
			case 'kraken':
				return $this->exchange->getJsonByPair($request->get('pair'), $request->get('interval'), $request->get('since'));
			case 'poloniex':
				return $this->exchange->getJsonByPair($request->get('pair'), $request->get('start'), $request->get('end'), $request->get('period'));
			default:
				return $this->exchange->getJsonByPair($request->get('pair'), $request->get('interval'));
		}
	}

	public function getTradeHistory(Request $request)
	{
		switch (config('exchange.selected')) {
			case 'kraken':
				return $this->exchange->getTradeHistory($request->get('pair'), $request->get('since'));
			case 'poloniex':
				return $this->exchange->getTradeHistory($request->get('pair'), $request->get('start'), $request->get('end'));
			default:
				return $this->exchange->getTradeHistory($request->get('pair'), $request->get('interval'));
		}
	}
}

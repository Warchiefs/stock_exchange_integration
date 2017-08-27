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
		//
	}

	public function getInfoAboutPair(Request $request)
	{
		//
	}

	public function getJsonByPair(Request $request)
	{
		//
	}

	public function getTradeHistory(Request $request)
	{
		//
	}
}

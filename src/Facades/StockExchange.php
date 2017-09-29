<?php

namespace Warchiefs\StockExchangeIntegration\Facades;

use Illuminate\Support\Facades\Facade;

class StockExchange extends Facade
{

	protected static function getFacadeAccessor()
	{
		return 'StockExchange';
	}
}
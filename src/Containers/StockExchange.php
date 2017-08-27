<?php

namespace Warchiefs\StockExchangeIntegration\Containers;

use Warchiefs\StockExchangeIntegration\Contracts\StockExchange as Exchange;

/**
 * Parent class for StockExchange
 *
 * @package Warchiefs\StockExchangeIntegration\Containers
 */
class StockExchange implements Exchange{

	protected $api_uri;

	/**
	 * Counstruct an url for api request
	 *
	 * @param       $method
	 * @param array $params
	 *
	 * @return string
	 */
	public function uri_construct($method, array $params = [])
	{
		if($params != []) {
			$params = http_build_query($params);
			return $this->api_uri.'/'.$method.'?'.$params;
		} else {
			return $this->api_uri.'/'.$method;
		}
	}

	/**
	 * Send api request
	 *
	 * @param       $method
	 * @param array $params
	 *
	 * @return string
	 */
	public function api_request($method, array $params = [])
	{
		$uri = $this->uri_construct($method, $params);

		return file_get_contents($uri);
	}

	// Functions for implements

	public function getAvailableQuotation()
	{
		//
	}

	public function getTradeHistory($first_currency = 'BTC', $second_currency = 'USD', $start = null, $end = null)
	{
		//
	}

	public function getJsonByPair($first_currency = 'BTC', $second_currency = 'USD')
	{
		//
	}

	public function getInfoAboutPair($first_currency = 'BTC', $second_currency = 'USD')
	{
		//
	}

}
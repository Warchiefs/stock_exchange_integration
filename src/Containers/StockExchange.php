<?php

namespace Warchiefs\StockExchangeIntegration\Containers;

use Warchiefs\StockExchangeIntegration\Contracts\StockExchange as Exchange;
use GuzzleHttp\Client;

/**
 * Parent class for StockExchange
 *
 * @package Warchiefs\StockExchangeIntegration\Containers
 */
abstract class StockExchange implements Exchange
{

	protected $api_uri;
	protected $client;

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
	 * @return null|string
	 */
	public function api_request($method, array $params = [])
	{
		$uri = $this->uri_construct($method, $params);
        $client = new Client();
        $request = $client->request('GET', $uri, ['http_errors' => false]);
        $response = $request->getBody()->getContents();

		return $response;
	}

    /**
     * Return avg of pair from all stock exchanges
     *
     * @param string $first_currency
     * @param string $second_currency
     * @return null|float
     */
    public static function getTickerAverage($first_currency = 'BTC', $second_currency = 'USD')
    {
        if (!($availableStocks = config('exchange.available'))) {
            $config = require_once('../Config/exchange.php');
            $availableStocks = $config['available'];
        }

        $prices = [];

        foreach ($availableStocks as $stock) {
            $class = __NAMESPACE__  . '\\' . ucfirst($stock);
            if (!class_exists($class)) {
                continue;
            }
            $stockExchange = new $class;
            if ($price = $stockExchange->getPairPrice($first_currency, $second_currency)) {
                $prices[$stock] = $price;
            }
        }

        if (count($prices) === 0) {
            return null;
        }

        return round(array_sum($prices) / count($prices), 8);
    }
}
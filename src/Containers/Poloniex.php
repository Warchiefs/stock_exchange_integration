<?php

namespace Warchiefs\StockExchangeIntegration\Containers;

/**
 * Class Poloniex
 *
 * https://poloniex.com/support/api/
 *
 * @package Warchiefs\StockExchangeIntegration\Containers
 */
class Poloniex extends StockExchange {

	/**
	 * Consts for second periods
	 */
	const EVERY_FIVE_MINUTES = 300;
	const EVERY_FIVETEEN_MINUTES = 900;
	const EVERY_HALF_HOUR = 1800;
	const EVERY_TWO_HOURS = 7200;
	const EVERY_FOUR_HOURS = 14400;
	const EVERY_DAY = 86400;

	public $api_uri = 'https://poloniex.com/public';

	/**
	 * Counstructor for Poloniex exchange
	 *
	 * @param       $method
	 * @param array $params
	 *
	 * @return string
	 */
	public function uri_construct($method, array $params = [ ])
	{
		$params['command'] = $method;

		return $this->api_uri.'?'.http_build_query($params);
	}

	/**
	 * Returns the 24-hour volume for all markets,
	 * plus totals for primary currencies. Sample output:
	 *
	 * {"BTC_LTC":{"BTC":"2.23248854","LTC":"87.10381314"},
	 * "BTC_NXT":{"BTC":"0.981616","NXT":"14145"}, ...
	 * "totalBTC":"81.89657704",
	 * "totalLTC":"78.52083806"}
	 *
	 * @return string
	 */
	public function getAvailableQuotation()
	{
		return $this->api_request('return24hVolume');
	}

	/**
	 * Returns the order book for a given market, as well as a sequence number
	 * for use with the Push API and an indicator specifying whether the market is frozen.
	 * You may set currencyPair to "all" to get the order books of all markets.
	 * Sample output:
	 *
	 * {"asks":[[0.00007600,1164],[0.00007620,1300], ... ],
	 * "bids":[[0.00006901,200],[0.00006900,408], ... ],
	 * "isFrozen": 0,
	 * "seq": 18849}
	 *
	 * @param string $first_currency
	 * @param string $second_currency
	 * @param int    $depth
	 *
	 * @return string
	 */
	public function getInfoAboutPair($first_currency = 'BTC', $second_currency = 'NXT', $depth = 10)
	{
		return $this->api_request('returnOrderBook', [
			'currencyPair'=> $first_currency.'_'.$second_currency,
			'depth' => $depth
		]);
	}

	/**
	 * Returns candlestick chart data.
	 * Required GET parameters are "currencyPair", "period"
	 * "start", and "end". "Start" and "end" are given in UNIX timestamp format
	 * and used to specify the date range for the data returned.
	 * Sample output:
	 *
	 * [{"date":1405699200,"high":0.0045388,"low":0.00403001,"open":0.00404545,"close":0.00427592,"volume":44.11655644,
	 * "quoteVolume":10259.29079097,"weightedAverage":0.00430015}, ...]
	 *
	 *
	 * @param string $first_currency
	 * @param string $second_currency
	 * @param int    $start
	 * @param int    $end
	 * @param int    $period
	 *
	 * @return string
	 */
	public function getJsonByPair($first_currency = 'BTC', $second_currency = 'NXT', $start = null, $end = 9999999999, $period = self::EVERY_FIVE_MINUTES)
	{
		// If start == null, start => day ago
		if(!$start) {
			$start = time() - self::EVERY_DAY;
		}

		return $this->api_request('returnChartData', [
			'currencyPair' => $first_currency.'_'.$second_currency,
			'start' => $start,
			'end' => $end,
			'period' => $period
		]);
	}

	/**
	 * Returns the past 200 trades for a given market,
	 * or up to 50,000 trades between a range specified in UNIX timestamps
	 * by the "start" and "end" GET parameters.
	 *
	 * Sample output:
	 *
	 * @param string $first_currency
	 * @param string $second_currency
	 * @param null   $start
	 * @param int   $end
	 *
	 * @return string
	 */
	public function getTradeHistory($first_currency = 'BTC', $second_currency = 'NXT', $start = null, $end = null)
	{
		if(!$start && !$end) {
			return $this->api_request('returnTradeHistory', [
				'currencyPair' => $first_currency.'_'.$second_currency
			]);
		} else {
			return $this->api_request('returnTradeHistory', [
				'currencyPair' => $first_currency.'_'.$second_currency,
				'start' => $start,
				'end' => $end
			]);
		}


	}

}
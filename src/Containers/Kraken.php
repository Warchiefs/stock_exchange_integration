<?php

namespace Warchiefs\StockExchangeIntegration\Containers;

/**
 * Class Kraken
 *
 * https://www.kraken.com/en-us/help/api
 *
 * @package Warchiefs\StockExchangeIntegration\Containers
 */
class Kraken extends StockExchange {

	/**
	 * Consts for minute periods
	 */
	const EVERY_MINUTE = 1;
	const EVERY_FIVE_MINUTES = 5;
	const EVERY_FIVETEEN_MINUTES = 15;
	const EVERY_HALF_HOUR = 30;
	const EVERY_HOUR = 60;
	const EVERY_FOUR_HOURS = 240;
	const EVERY_DAY = 1440;
	const EVERY_7_DAYS = 10080;
	const EVERY_15_DAYS = 21600;

	public $api_uri = 'https://api.kraken.com/0/public/';

	/**
	 * Get tradable asset pairs
	 * https://www.kraken.com/en-us/help/api#get-tradable-pairs
	 *
	 * @return string
	 */
	public function getAvailableQuotation()
	{
		return $this->api_request('AssetPairs');
	}

	/**
	 * Get detailed info about ticker
	 * https://www.kraken.com/en-us/help/api#get-ticker-info
	 *
	 * @param string $first_currency
	 * @param string $second_currency
	 *
	 * @return string
	 */
	public function getInfoAboutPair($first_currency = 'BCH', $second_currency = 'USD')
	{
		return $this->api_request('Ticker', ['pair' => $first_currency.$second_currency]);
	}

	/**
	 * Get OHLC data
	 * https://www.kraken.com/en-us/help/api#get-ohlc-data
	 *
	 * @param string $first_currency
	 * @param string $second_currency
	 * @param int    $interval
	 * @param null   $since
	 *
	 * @return string
	 */
	public function getJsonByPair($first_currency = 'BCH', $second_currency = 'USD', $interval = self::EVERY_MINUTE, $since = null)
	{
		if(!$since) {
			return $this->api_request('OHLC', [
				'pair' => $first_currency.$second_currency,
				'interval' => $interval
			]);
		} else {
			return $this->api_request('OHLC', [
				'pair' => $first_currency.$second_currency,
				'interval' => $interval,
				'since' => $since
			]);
		}
	}

	/**
	 * Get recent trades
	 * https://www.kraken.com/en-us/help/api#get-recent-trades
	 *
	 * @param string $first_currency
	 * @param string $second_currency
	 * @param null   $since
	 *
	 * @return string
	 */
	public function getTradeHistory($first_currency = 'BTC', $second_currency = 'USD', $since = null)
	{
		if(!$since) {
			return $this->api_request('Trades', [
				'pair' => $first_currency.$second_currency
			]);
		} else {
			return $this->api_request('Trades', [
				'pair' => $first_currency.$second_currency,
				'since' => $since
			]);
		}

	}

}
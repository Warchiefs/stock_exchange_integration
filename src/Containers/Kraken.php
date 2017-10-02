<?php

namespace Warchiefs\StockExchangeIntegration\Containers;

/**
 * Class Kraken
 *
 * https://www.kraken.com/en-us/help/api
 *
 * @package Warchiefs\StockExchangeIntegration\Containers
 */
class Kraken extends StockExchange
{

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

	public $api_uri = 'https://api.kraken.com/0/public';

	/**
	 * Get tradable asset pairs
	 * https://www.kraken.com/en-us/help/api#get-tradable-pairs
	 *
	 * @return null|array
	 */
	public function getAvailableQuotation()
	{
	    $responseJSON = $this->api_request('AssetPairs');
		$response = json_decode($responseJSON, true);

		return $response;
	}

	/**
	 * Get detailed info about ticker
	 * https://www.kraken.com/en-us/help/api#get-ticker-info
	 *
	 * @param string $first_currency
	 * @param string $second_currency
	 *
	 * @return null|array
	 */
	public function getInfoAboutPair($first_currency = 'BCH', $second_currency = 'USD')
	{
        $responseJSON = $this->api_request('Ticker', ['pair' => $this->getPair($first_currency, $second_currency),]);
        $response = json_decode($responseJSON, true);

        if (!$response || $response['error'] != []) {
            return null;
        }

        return $response['result'];
	}

    /**
     * Return chart data of currency pair
     *
     * data format: [[timestamp, high, low, open, close, advancedData]]
     *
     * min start time - 2 monthes ago
     *
     * @param string $first_currency
     * @param string $second_currency
     * @param int $interval
     * @param null $since
     * @return null|array
     */
    public function getChartData($first_currency = 'BCH', $second_currency = 'USD', $interval = self::EVERY_DAY, $since = null)
    {
        if(!$since) {
            $responseJSON = $this->api_request('OHLC', [
                'pair' => $this->getPair($first_currency, $second_currency),
                'interval' => $interval,
            ]);
        } else {
            $responseJSON = $this->api_request('OHLC', [
                'pair' => $this->getPair($first_currency, $second_currency),
                'interval' => $interval,
                'since' => $since,
            ]);
        }

        $response = json_decode($responseJSON, true);

        if (!$response || $response['error'] != []) {
            return null;
        }

        foreach ($response['result'] as $item) {
            $data = $item;
            break;
        }

        $returnData = [];

        foreach ($data as $item) {
            $currentData = [];
            $currentData['timestamp'] = $item[0];
            $currentData['open'] = $item[1];
            $currentData['high'] = $item[2];
            $currentData['low'] = $item[3];
            $currentData['close'] = $item[4];
            $currentData['advancedData'] = [
                'vwap' => $item[5],
                'volume' => $item[6],
                'count' => $item[7],
            ];
            $returnData[] = $currentData;
        }

        return $returnData;
    }

	/**
	 * Get recent trades
	 * https://www.kraken.com/en-us/help/api#get-recent-trades
	 *
	 * @param string $first_currency
	 * @param string $second_currency
	 * @param null   $since
	 *
	 * @return null|array
	 */
	public function getTradeHistory($first_currency = 'BCH', $second_currency = 'USD', $since = null)
	{
		if(!$since) {
            $responseJSON = $this->api_request('Trades', [
				'pair' => $this->getPair($first_currency, $second_currency),
			]);
		} else {
            $responseJSON =  $this->api_request('Trades', [
				'pair' => $this->getPair($first_currency, $second_currency),
				'since' => $since
			]);
		}

        $response = json_decode($responseJSON, true);

        if (!$response || $response['error'] != []) {
            return null;
        }

        return $response['result'];
	}

    /**
     * Return available coins
     *
     * @return array
     */
    public function getAvailableCoins()
    {
        $responseJSON = $this->api_request('Assets');
        $response = json_decode($responseJSON, true);

        if (!$response || $response['error'] != []) {
            return null;
        }

        return array_keys($response['result']);
    }

    /**
     * Return price of pair
     *
     * @param string $first_currency
     * @param string $second_currency
     * @return null|float
     */
    public function getPairPrice($first_currency = 'BCH', $second_currency = 'USD')
    {
        $pair = $this->getPair($first_currency, $second_currency);

        $tickerJSON = $this->api_request('Ticker', compact('pair'));
        $ticker = json_decode($tickerJSON, true);

        if ($ticker['error'] != []) {
            return null;
        }

        foreach ($ticker['result'] as $item) {
            return (float) $item['c'][0];
        }
    }

    public function getPair($first_currency = 'BCH', $second_currency = 'USD')
    {
        if ($first_currency === 'BTC') {
            $first_currency = 'XBT';
        }
        if ($second_currency === 'BTC') {
            $second_currency = 'XBT';
        }

        return $first_currency . $second_currency;
    }
}
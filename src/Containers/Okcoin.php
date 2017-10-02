<?php

namespace Warchiefs\StockExchangeIntegration\Containers;

/**
 * Class Okcoin
 *
 * @package Warchiefs\StockExchangeIntegration\Containers
 */
class Okcoin extends StockExchange
{
    public $api_uri = 'https://www.okcoin.com/api/v1';

    const TYPE_1_MIN = '1min';
    const TYPE_3_MIN = '3min';
    const TYPE_5_MIN = '5min';
    const TYPE_15_MIN = '15min';
    const TYPE_30_MIN = '13min';
    const TYPE_1_DAY = '1day';
    const TYPE_3_DAY = '3day';
    const TYPE_1_WEEK = '1week';
    const TYPE_1_HOUR = '1hour';
    const TYPE_2_HOUR = '2hour';
    const TYPE_4_HOUR = '4hour';
    const TYPE_6_HOUR = '6hour';
    const TYPE_12_HOUR = '12hour';


    public function getAvailableQuotation()
    {
        return null;
    }

    /**
     * Get Price Ticker
     *
     * @param string $first_currency
     * @param string $second_currency
     * @return null|array
     */
    public function getInfoAboutPair($first_currency = 'BTC', $second_currency = 'USD')
    {
        $data['symbol'] = $this->getPair($first_currency, $second_currency);
        $responseJSON = $this->api_request('ticker.do', $data);
        $response = json_decode($responseJSON, true);

        if (isset($response['error_code'])) {
            return null;
        }

        return $response['ticker'];
    }

    /**
     * Get Trade
     *
     * @param string $first_currency
     * @param string $second_currency
     * @param null $since
     * @return array|null
     */
    public function getTradeHistory($first_currency = 'BTC', $second_currency = 'USD', $since = null)
    {
        $data['symbol'] = $this->getPair($first_currency, $second_currency);
        $responseJSON = $this->api_request('trades.do', $data);
        $response = json_decode($responseJSON, true);

        if (isset($response['error_code'])) {
            return null;
        }

        return $response;
    }

    /**
     * Return available coins
     *
     * @return array
     */
    public function getAvailableCoins()
    {
        return [
            'BTC',
            'LTC',
            'ETH',
            'ETC',
            'BCC',
        ];
    }

    /**
     * Get pair price
     *
     * @param string $first_currency
     * @param string $second_currency
     * @return float|null
     */
    public function getPairPrice($first_currency = 'BTC', $second_currency = 'USD')
    {
        $data['symbol'] = $this->getPair($first_currency, $second_currency);
        $responseJSON = $this->api_request('ticker.do', $data);
        $response = json_decode($responseJSON, true);

        if (isset($response['error_code'])) {
            return null;
        }

        return (float) $response['ticker']['last'];
    }

    /**
     * Get chart data
     *
     * data format: [[timestamp, high, low, open, close, advancedData]]
     *
     * @param string $first_currency
     * @param string $second_currency
     * @param string $type  candlestick data
     * @param null $size    specify data size to be acquired
     * @param null $since   timestamp(eg:1417536000000). data after the timestamp will be returned
     * @return null|array
     */
    public function getChartData($first_currency = 'BTC', $second_currency = 'USD', $type = self::TYPE_1_MIN, $size = null, $since = null)
    {
        $data = [];
        $data['symbol'] = $this->getPair($first_currency, $second_currency);
        $data['type'] = $type;
        if ($size) {
            $data['size'] = $size;
        }
        if ($since) {
            $data['since'] = $since;
        }

        $responseJSON = $this->api_request('kline.do', $data);
        $response = json_decode($responseJSON, true);

        if (isset($response['error_code'])) {
            return null;
        }

        $returnData = [];

        foreach ($response as $item) {
            $currentData = [];
            $currentData['timestamp'] = $item[0];
            $currentData['open'] = $item[1];
            $currentData['high'] = $item[2];
            $currentData['low'] = $item[3];
            $currentData['close'] = $item[4];
            $currentData['advancedData'] = [
                'volume' => $item[5],
            ];
            $returnData[] = $currentData;
        }

        return $returnData;
    }

    /**
     * get symbol
     *
     * @param string $first_currency
     * @param string $second_currency
     * @return string
     */
    protected function getPair($first_currency = 'BTC', $second_currency = 'USD')
    {
        return strtolower($first_currency . '_' . $second_currency);
    }
}
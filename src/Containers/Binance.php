<?php

namespace Warchiefs\StockExchangeIntegration\Containers;

/**
 * Class Binance
 *
 * @package Warchiefs\StockExchangeIntegration\Containers
 */
class Binance extends StockExchange
{
    public $api_uri = 'https://www.binance.com/api/v1';

    public function getAvailableQuotation()
    {
        return null;
    }

    public function getInfoAboutPair($first_currency = 'BTC', $second_currency = 'USD')
    {
        return null;
    }

    public function getTradeHistory($first_currency = 'BTC', $second_currency = 'USD')
    {
        return null;
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
            'WTC',
            'NEO',
            'LINK',
            'BNB',
            'BNB',
            'QTUM',
            'SALT',
        ];
    }

    /**
     * Get pair price
     *
     * @param string $first_currency
     * @param string $second_currency
     * @return float|null
     */
    public function getPairPrice($first_currency = 'BTC', $second_currency = 'USDT')
    {
        $responseJSON = $this->api_request("ticker/allPrices");
        $response = json_decode($responseJSON, true);

        if (!$response) {
            return null;
        }

        $pair = $this->getPair($first_currency, $second_currency);

        $prices = array_column($response, 'price', 'symbol');

        if (!isset($prices[$pair])) {
            return null;
        }

        return (float) $prices[$pair];
    }

    public function getChartData($first_currency = 'BTC', $second_currency = 'USDT')
    {
        return null;
    }

    /**
     * get pair
     *
     * @param string $first_currency
     * @param string $second_currency
     * @return string
     */
    private function getPair($first_currency = 'BTC', $second_currency = 'USDT')
    {
        if ($second_currency === 'USD') {
            $second_currency .= 'T';
        }

        return $first_currency . $second_currency;
    }
}
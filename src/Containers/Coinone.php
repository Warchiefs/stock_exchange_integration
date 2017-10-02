<?php

namespace Warchiefs\StockExchangeIntegration\Containers;

/**
 * Class Coinone
 *
 * @package Warchiefs\StockExchangeIntegration\Containers
 */
class Coinone extends StockExchange
{
    public $api_uri = 'https://api.coinone.co.kr';
    protected $fiat = 'KRW';
    protected $onlyFiat = true;

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
            'btc',
            'bch',
            'eth',
            'etc',
            'xrp',
            'qtum',
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
        $currency = $this->getPair($first_currency, $second_currency);
        $responseJSON = $this->api_request("ticker", compact('currency'));
        $response = json_decode($responseJSON, true);

        if (!$response || $response['result'] !== 'success' || !isset($response['last'])) {
            return null;
        }

        return (float) $response['last'];
    }

    public function getChartData($first_currency = 'BTC', $second_currency = 'USD')
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
    private function getPair($first_currency = 'BTC', $second_currency = 'USD')
    {
        return strtolower($first_currency);
    }
}
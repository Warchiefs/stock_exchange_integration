<?php

namespace Warchiefs\StockExchangeIntegration\Containers;

/**
 * Class Btc38
 *
 * @package Warchiefs\StockExchangeIntegration\Containers
 */
class Btc38 extends StockExchange
{
    public $api_uri = 'http://api.btc38.com/v1';
    protected $fiat = 'CNY';
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
     * @return null|array
     */
    public function getAvailableCoins()
    {
        $responseJSON = $this->api_request("ticker.php", ['c' => 'all']);
        $response = json_decode($responseJSON, true);

        if (!$response || !is_array($response)) {
            return null;
        }

        return array_keys($response);
    }

    /**
     * Get pair price
     *
     * @param string $first_currency
     * @param string $second_currency
     * @return float|null
     */
    public function getPairPrice($first_currency = 'BTC', $second_currency = 'CNY')
    {
        $c = $this->getPair($first_currency, $second_currency);
        $responseJSON = $this->api_request("ticker.php", compact('c'));
        $response = json_decode($responseJSON, true);

        if (!$response || !is_array($response)) {
            return null;
        }

        return (float) $response['ticker']['last'];
    }

    public function getChartData($first_currency = 'BTC', $second_currency = 'CNY')
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
    private function getPair($first_currency = 'BTC', $second_currency = 'CNY')
    {
        return strtolower($first_currency);
    }
}
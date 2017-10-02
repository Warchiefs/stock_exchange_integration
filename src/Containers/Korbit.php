<?php

namespace Warchiefs\StockExchangeIntegration\Containers;

/**
 * Class Korbit
 *
 * @package Warchiefs\StockExchangeIntegration\Containers
 */
class Korbit extends StockExchange
{
        public $api_uri = 'https://api.korbit.co.kr/v1';
    protected $fiat = 'KRW';

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
            'BCH',
            'ETH',
            'ETC',
            'XRP',
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
        $currency_pair = $this->getPair($first_currency, $second_currency);
        $responseJSON = $this->api_request("ticker", compact('currency_pair'));
        $response = json_decode($responseJSON, true);

        if (!$response || isset($response['error'])) {
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
        return strtolower($first_currency . '_krw');
    }
}
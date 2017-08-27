<?php

namespace Warchiefs\StockExchangeIntegration\Contracts;

interface StockExchange {

	/**
	 * Return information about available pairs
	 * from stock exchange
	 *
	 * @return mixed
	 */
	public function getAvailableQuotation();

	/**
	 * Return detail information about pair
	 *
	 * @param string $first_currency
	 * @param string $second_currency
	 *
	 * @return mixed
	 */
	public function getInfoAboutPair($first_currency = 'BTC', $second_currency = 'USD');

	/**
	 * Return JSON data
	 * for chart about currency pair
	 *
	 * @param string $first_currency
	 * @param string $second_currency
	 *
	 * @return mixed
	 */
	public function getJsonByPair($first_currency = 'BTC', $second_currency = 'USD');

	/**
	 * Return trade history
	 * for currency pair
	 * for timestamps ranges
	 *
	 * @param string $first_currency
	 * @param string $second_currency
	 *
	 * @return mixed
	 */
	public function getTradeHistory($first_currency = 'BTC', $second_currency = 'USD');

}